<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body >
    <div class="con-LSP-message">
        <h1 class="mern_slider_font">Like Share Print</h1>
        <div class="lsp-message-con"></div>
    </div>

<div class="LSP_con">
    <nav class="nav-tab-wrapper lsp-nav-tab-wrapper">
        <a href="#" class="nav-tab nav-tab-active" nav-data="LSP-like">Like</a>
        <a href="#" class="nav-tab " nav-data="LSP-social-share">Social Share</a>
        <a href="#" class="nav-tab " nav-data="LSP-print">Print</a>
        <a href="#" class="nav-tab " nav-data="LSP-settings">Settings</a>
    </nav>
    <div class="LSP_tab_content active" id="LSP-like">
        <h2>Like</h2>
        <?php  include __DIR__ . '\backend\like.php'; ?>
    </div>
    <div class="LSP_tab_content" id="LSP-social-share">
        <h2>Share</h2>
        <?php  include __DIR__ . '\backend\social-share.php'; ?>
    </div>
    <div class="LSP_tab_content" id="LSP-print">
        <h2>Print</h2>
        <?php  include __DIR__ . '\backend\print.php'; ?>
    </div>
    <div class="LSP_tab_content" id="LSP-settings">
        <h2>Global Settings</h2>
        <?php  include __DIR__ . '\backend\settings.php'; ?>
    </div>
</div>


</body>
</html>

