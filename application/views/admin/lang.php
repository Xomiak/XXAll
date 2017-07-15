<?php
$langs = array();

$languages = $this->model_languages->getLanguages();
for($i = 0; $i < count($languages); $i++)
{
    $langs[$i] = $languages[$i]['code'];
}
$default_lang = $this->model_languages->getDefaultLanguage();
if(isset($default_lang['code'])) $default_lang = $default_lang['code'];
$current_lang = (userdata('language')) ? userdata('language') : trim($default_lang);

if(count($languages) > 1) {
?>
<div>
    <div id="language" style="margin:20px auto;text-align: center; width: 150px; height: 25px;" >
        <?php $langs[0] = trim($langs[0]); ?>
        <span class="curr_lang"><?= $langs[0] ?></span>&nbsp;
        <?php
        for ($i = 1; $i < count($langs); $i++) {
            $langs[$i] = trim($langs[$i]);
            ?>
            <span class="langs"><?= $langs[$i] ?></span>&nbsp;
        <?php } ?>
    </div>
</div>
<?php } ?>