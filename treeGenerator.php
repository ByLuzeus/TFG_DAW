<?php
/**
 * treeGenerator.php
 * Recorre recursivamente el proyecto, omite carpetas pesadas
 * y ahora vuelca en DOS ficheros:
 *
 *  1) estructuraCarpetas.txt
 *     → Árbol de carpetas/archivos (solo nombres)
 *
 *  2) estructuraArchivos.txt
 *     → Nombre + contenido de archivos clave
 *       (.php, .css, .js, .json, etc. + .htaccess, composer.*, phpunit.xml.dist)
 */

// Ruta raíz (donde está este script)
$root = __DIR__;

// Ficheros de salida
$treeFile    = $root . '/estructuraCarpetas.txt';
$filesFile   = $root . '/estructuraArchivos.txt';

// Carpetas a omitir
$exclDirs = ['vendor', 'tmp', 'logs', 'tests', '.git', '.github'];

// Extensiones de archivos a incluir en el volcado de contenido
$includeExts = ['php','ctp','css','js','html','twig','ini','json','xml','yml','lock'];

// Archivos sueltos (sin extensión) a incluir siempre
$includeFiles = ['.htaccess','index.php','phpunit.xml.dist','composer.json','composer.lock'];

// Abrimos los ficheros de salida
$fpTree = fopen($treeFile, 'w');
if (!$fpTree) {
    die("No se pudo abrir $treeFile para escritura\n");
}

$fpFiles = fopen($filesFile, 'w');
if (!$fpFiles) {
    fclose($fpTree);
    die("No se pudo abrir $filesFile para escritura\n");
}

/**
 * Escribe en el fichero la estructura de carpetas en formato árbol.
 */
function listarEstructura($dir, $fp, $prefijo, $exclDirs) {
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        if (in_array($item, $exclDirs, true)) {
            continue;
        }

        $path = $dir . DIRECTORY_SEPARATOR . $item;
        fwrite($fp, $prefijo . $item . "\n");

        if (is_dir($path)) {
            listarEstructura($path, $fp, $prefijo . '    ', $exclDirs);
        }
    }
}

/**
 * Recorre todo el proyecto y vuelca el contenido de los archivos filtrados.
 */
function volcarContenidos($dir, $fp, $exts, $includeFiles, $exclDirs) {
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($it as $file) {
        $basename = $file->getFilename();   
        $pathname = $file->getPathname();

        // Ruta relativa desde $dir
        $relative = ltrim(str_replace($dir, '', $pathname), DIRECTORY_SEPARATOR);
        $parts = explode(DIRECTORY_SEPARATOR, $relative);

        // Si la ruta pasa por una carpeta excluida, la saltamos
        if (array_intersect($parts, $exclDirs)) {
            continue;
        }

        $ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));

        // Volcamos si está en la lista de extensiones o en archivos sueltos
        if (in_array($ext, $exts, true) || in_array($basename, $includeFiles, true)) {
            fwrite($fp, "\n\n=== Archivo: $relative ===\n\n");
            $content = @file_get_contents($pathname);
            if ($content === false) {
                fwrite($fp, "[No se pudo leer el archivo]\n");
            } else {
                fwrite($fp, $content);
            }
        }
    }
}

// 1) Listado de estructura (solo nombres) → estructuraCarpetas.txt
fwrite($fpTree, "=== Estructura de carpetas y archivos ===\n\n");
listarEstructura($root, $fpTree, '', $exclDirs);

// 2) Volcado de contenidos → estructuraArchivos.txt
fwrite($fpFiles, "=== Contenidos de archivos seleccionados ===\n");
volcarContenidos($root, $fpFiles, $includeExts, $includeFiles, $exclDirs);

// Cerramos y avisamos
fclose($fpTree);
fclose($fpFiles);

echo "¡Hecho!\n";
echo " - Estructura: $treeFile\n";
echo " - Archivos + contenido: $filesFile\n";