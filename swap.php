<?php
$content = file_get_contents('resources/views/auth/register.blade.php');

$step2_start = "                    @if(\$role === 'petani')\n                    <!-- STEP 2: Kelompok -->";
$step2_end = "                    </div>\n\n                    <!-- STEP 3: Ketua -->";

$step3_start = "                    <!-- STEP 3: Ketua -->";
$step3_end = "                    </div>\n\n                    <!-- STEP 4: Lahan -->";

// Find positions
$pos2_start = strpos($content, "                    <!-- STEP 2: Kelompok -->");
$pos3_start = strpos($content, "                    <!-- STEP 3: Ketua -->");
$pos4_start = strpos($content, "                    <!-- STEP 4: Lahan -->");

$step2_content = substr($content, $pos2_start, $pos3_start - $pos2_start);
$step3_content = substr($content, $pos3_start, $pos4_start - $pos3_start);

// Update step attributes
$step2_content = str_replace("x-show=\"step === 2\"", "x-show=\"step === 3\"", $step2_content);
$step2_content = str_replace(":required=\"step === 2\"", ":required=\"step === 3\"", $step2_content);
$step2_content = str_replace("<!-- STEP 2: Kelompok -->", "<!-- STEP 3: Kelompok -->", $step2_content);

$step3_content = str_replace("x-show=\"step === 3\"", "x-show=\"step === 2\"", $step3_content);
$step3_content = str_replace(":required=\"step === 3\"", ":required=\"step === 2\"", $step3_content);
$step3_content = str_replace("<!-- STEP 3: Ketua -->", "<!-- STEP 2: Ketua -->", $step3_content);

// Swap
$new_content = substr($content, 0, $pos2_start) . $step3_content . $step2_content . substr($content, $pos4_start);

file_put_contents('resources/views/auth/register.blade.php', $new_content);
echo "Swapped successfully.\n";
