<div<?php print $attributes; ?>>
    <div class="top_header">
      <?php print render($page['top_header']); ?>
      <?php if ($variables['logout_block']): ?>
        <?php print render($variables['logout_block']); ?>
      <?php endif; ?>
    </div>
  <header class="l-header" role="banner">
    <div class="l-branding">
      <?php if ($logo): ?>
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="site-logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
      <?php endif; ?>

      <?php if ($site_name || $site_slogan): ?>
        <?php if ($site_name): ?>
          <h1 class="site-name">
            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
          </h1>
        <?php endif; ?>

        <?php if ($site_slogan): ?>
          <h2 class="site-slogan"><?php print $site_slogan; ?></h2>
        <?php endif; ?>
      <?php endif; ?>

      <?php print render($page['branding']); ?>
    </div>
    <?php print render($page['header']); ?>
    <?php print render($page['navigation']); ?>
      <?php print $breadcrumb; ?>
  </header>

  <div class="l-main">



      <div class="above_content"><?php print render($page['above_content']); ?></div>
    <?php print render($page['sidebar_first']); ?>
    <div class="l-content" role="main">
      <?php print render($page['highlighted']); ?>
      <a id="main-content"></a>
      <?php print $messages; ?>
      <?php if ($variables['article_node_messages']): ?>
        <div class="article_messages"><?php print $variables['article_node_messages']; ?></div>
      <?php endif; ?>
      <?php if ($variables['time_revision']): ?>
        <div class="about-revision"><?php print t("You are currently editing a revision of this post created on ") . $variables['time_revision'] . t(" by ") . l($variables['revision_name']->name,  'user/' . $variables['node']->revision_uid, array('html' => true)); ?></div>
      <?php endif; ?>
      <?php print render($tabs); ?>
      <?php if ($variables['outline_node_messages']): ?>
        <div class="outline_node_messages"><?php print $variables['outline_node_messages']; ?></div>
      <?php endif; ?>
      <?php if ($variables['revision_node_messages']): ?>
        <div class="revision_node_messages"><?php print $variables['revision_node_messages']; ?></div>
      <?php endif; ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <h1><?php print $title; ?></h1>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php print render($page['content']); ?>
      <?php print $feed_icons; ?>
    </div>


    <?php print render($page['sidebar_second']); ?>
  </div>

    <div class="under_content">
        <?php print render($page['under_content']); ?>
    </div>
  <footer class="l-footer" role="contentinfo">
    <?php print render($page['footer']); ?>
  </footer>
</div>
