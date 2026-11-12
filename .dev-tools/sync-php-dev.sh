
#!/bin/bash

set -e

# ==========================================
# PHP DEV SYNC - Kubernetes VDS
# ==========================================

CONTEXT="vds-kubernetes"
NAMESPACE="default"
DEPLOYMENT="intranet-php-dev"
CONTAINER="intranet-php"

REPO_ROOT="$(cd "$(dirname "$0")/.." && pwd)"
LOCAL_DIR="$REPO_ROOT/src"
REMOTE_DIR="/var/www/html"

MODE="${1:-}"

# ==========================================
# Validaciones de seguridad
# ==========================================

if [[ "$MODE" != "--dry-run" && "$MODE" != "--apply" ]]; then
    echo "Uso:"
    echo "$0 --dry-run"
    echo "$0 --apply"
    exit 1
fi

if [[ ! -d "$LOCAL_DIR" ]]; then
    echo "ERROR: No existe $LOCAL_DIR"
    exit 1
fi

if [[ "$(kubectl config current-context)" != "$CONTEXT" ]]; then
    echo "ERROR: Contexto Kubernetes incorrecto."
    echo "Contexto requerido: $CONTEXT"
    exit 1
fi

# Comprobar que el Deployment existe
kubectl --context="$CONTEXT" \
    get deployment "$DEPLOYMENT" -n "$NAMESPACE" >/dev/null

# Identificar el único Pod DEV en ejecución
PODS=$(kubectl --context="$CONTEXT" \
    get pods -n "$NAMESPACE" \
    -l app=intranet-php-dev \
    --field-selector=status.phase=Running \
    -o jsonpath='{range .items[*]}{.metadata.name}{"\n"}{end}')

COUNT=$(printf '%s\n' "$PODS" | sed '/^$/d' | wc -l | tr -d ' ')

if [[ "$COUNT" != "1" ]]; then
    echo "ERROR: Se esperaba exactamente un Pod DEV."
    exit 1
fi

POD="$PODS"

if [[ "$POD" != intranet-php-dev-* ]]; then
    echo "ERROR: Pod no autorizado: $POD"
    exit 1
fi

echo "=========================================="
echo " PHP DEV SYNC"
echo "=========================================="
echo "Contexto: $CONTEXT"
echo "Deployment: $DEPLOYMENT"
echo "Pod: $POD"
echo "Origen: $LOCAL_DIR"
echo "Destino: $REMOTE_DIR"
echo "Modo: $MODE"
echo "=========================================="

# ==========================================
# Obtener cambios Git
# ==========================================

TMP_FILE=$(mktemp)
trap 'rm -f "$TMP_FILE"' EXIT

git -C "$REPO_ROOT" diff --name-only -z HEAD -- src > "$TMP_FILE"
git -C "$REPO_ROOT" ls-files --others --exclude-standard -z -- src >> "$TMP_FILE"

FILES=()

while IFS= read -r -d '' FILE; do

    # Solo archivos PHP
    [[ "$FILE" == *.php ]] || continue

    RELATIVE="${FILE#src/}"

    # Proteger directorios persistentes hostPath
    case "$RELATIVE" in
        FILES/*|FILES) continue ;;
        ComunicacionInterna/Personal/FILES/*|ComunicacionInterna/Personal/FILES) continue ;;
        ComunicacionInterna/Personal/Expedientes/*|ComunicacionInterna/Personal/Expedientes) continue ;;
        ComunicacionInterna/Personal/CartaCompromisoSGI/*|ComunicacionInterna/Personal/CartaCompromisoSGI) continue ;;
        ComunicacionInterna/Personal/perfiles_puestos/*|ComunicacionInterna/Personal/perfiles_puestos) continue ;;
        ComunicacionInterna/Boletines/*|ComunicacionInterna/Boletines) continue ;;
        ComunicacionInterna/SeguimientoEtapas/*|ComunicacionInterna/SeguimientoEtapas) continue ;;
        ComunicacionInterna/SugerenciaQueja/*|ComunicacionInterna/SugerenciaQueja) continue ;;
        SistemaGestionIntegral/SimulacroArchivos/*|SistemaGestionIntegral/SimulacroArchivos) continue ;;
        SistemaGestionIntegral/SeguimientoEtapas/*|SistemaGestionIntegral/SeguimientoEtapas) continue ;;
        SistemaGestionIntegral/ReunionArchivo/*|SistemaGestionIntegral/ReunionArchivo) continue ;;
        SistemaGestionIntegral/ProcesoArchivos/*|SistemaGestionIntegral/ProcesoArchivos) continue ;;
        SistemaGestionIntegral/PreventivaCorrectiva/*|SistemaGestionIntegral/PreventivaCorrectiva) continue ;;
    esac

    [[ -f "$REPO_ROOT/$FILE" ]] || continue

    FILES+=("$FILE")

done < "$TMP_FILE"

if [[ ${#FILES[@]} -eq 0 ]]; then
    echo "No hay archivos PHP modificados para sincronizar."
    exit 0
fi

# ==========================================
# Mostrar archivos
# ==========================================

echo ""
echo "Archivos PHP detectados: ${#FILES[@]}"
echo ""

for FILE in "${FILES[@]}"; do
    echo "  -> $FILE"
done

if [[ "$MODE" == "--dry-run" ]]; then
    echo ""
    echo "DRY RUN: No se modificó ningún archivo."
    exit 0
fi

# ==========================================
# Sincronización exclusiva DEV
# ==========================================

echo ""
echo "Iniciando sincronización..."

for FILE in "${FILES[@]}"; do

    RELATIVE="${FILE#src/}"
    LOCAL_FILE="$REPO_ROOT/$FILE"
    REMOTE_FILE="$REMOTE_DIR/$RELATIVE"
    REMOTE_PARENT="${REMOTE_FILE%/*}"

    echo "Actualizando: $RELATIVE"

    kubectl --context="$CONTEXT" exec \
        -n "$NAMESPACE" "$POD" \
        -c "$CONTAINER" -- \
        mkdir -p "$REMOTE_PARENT"

    kubectl --context="$CONTEXT" cp \
        "$LOCAL_FILE" \
        "$NAMESPACE/$POD:$REMOTE_FILE" \
        -c "$CONTAINER"

done

echo ""
echo "=========================================="
echo " SINCRONIZACION COMPLETADA"
echo " Archivos actualizados: ${#FILES[@]}"
echo " Destino: intranet-php-dev"
echo "=========================================="

