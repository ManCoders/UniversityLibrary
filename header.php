<?php 
include 'auth/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo get_option('system_description')?>">
    <title><?php echo get_option('system_title')?></title><?php render_styles()?>
    <?php render_scripts() ?>
    <script>
        var base_url = '<?php echo base_url() ?>';
        
    </script>
    
</head>
    <body class="bg-light-300">