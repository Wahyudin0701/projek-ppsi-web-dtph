<?php
$base_dir = __DIR__ . '/../resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base_dir));

$replacements = [
    '$isAlsintan ? $proposal->alsintan->name : $proposal->program->name' => '$isAlsintan ? ($proposal->alsintan?->name ?? \'-\') : ($proposal->program?->name ?? \'-\')',
    '$isAlsintan ? $prop->alsintan->name : $prop->program->name' => '$isAlsintan ? ($prop->alsintan?->name ?? \'-\') : ($prop->program?->name ?? \'-\')',
    '$proposal->alsintan_id ? $proposal->alsintan->name : $proposal->program->name' => '$proposal->alsintan_id ? ($proposal->alsintan?->name ?? \'-\') : ($proposal->program?->name ?? \'-\')',
    '\'peminjaman alsintan \' . $proposal->alsintan->name : \'bantuan \' . $proposal->program->name' => '\'peminjaman alsintan \' . ($proposal->alsintan?->name ?? \'-\') : \'bantuan \' . ($proposal->program?->name ?? \'-\')',
    '$proposal->alsintan->name ?? ' => '$proposal->alsintan?->name ?? ',
    '$proposal->alsintan->name' => '($proposal->alsintan?->name ?? \'-\')',
    '$proposal->alsintan->image' => '$proposal->alsintan?->image',
    '$proposal->alsintan->merk' => '($proposal->alsintan?->merk ?? \'-\')',
    '$proposal->program->name' => '($proposal->program?->name ?? \'-\')',
    '$prop->alsintan->name' => '($prop->alsintan?->name ?? \'-\')',
    '$prop->program->name' => '($prop->program?->name ?? \'-\')',
];

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        $original = $content;
        
        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        
        if ($content !== $original) {
            file_put_contents($path, $content);
            echo "Updated: $path<br>\n";
        }
    }
}
echo "DONE";
