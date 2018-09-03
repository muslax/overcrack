<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <link rel="alternate" type="application/rss+xml" title="RSS" href="/rss.xml" />
        <meta name="viewport" content="width=device-width" />
        <link rel="apple-touch-icon-precomposed" href="/apple-touch-icon.png"/>
        <title><?= 
            (isset($content['post']) ? h($content['post']['post-title']) . ' &ndash; ' : '') . 
            ($content['page-title'] != $content['blog-title'] && (
                $content['page-type'] == 'page' || $content['page-type'] == 'archive' || $content['page-type'] == 'tag' || $content['page-type'] == 'type' 
            ) ? h($content['page-title']) . ' &ndash; ' : '') . 
            h($content['blog-title']) . ($content['page-type'] == 'year-archive' ? ' ' . substr($content['page-title'], -4) : '')
        ?></title>
        <link rel="stylesheet" href="/main.css" type="text/css">
        <? if ($content['page-type'] != 'frontpage' && $content['page-type'] != 'page' && $content['page-type'] != 'post') { ?>
            <meta name="robots" content="noindex"/>
        <? } ?>
    </head>
    <body class="<?= $content['page-type'] ?>">
        <div id="mastheadbackground">
            <div id="green-bg"></div>
        </div>
        
        <section id="posts">

            <div id="masthead">
                <a id="logo" href="/" title="Overcrack"><img src="/media/overcrack-white.svg"></a>
                <p id="tagline"><span>✪</span><?= $content['blog-description'] ?></p>
                <nav id="top-menu">
                    <a href="/about">About</a>&nbsp;/
                    <a href="/contact">Contact</a>&nbsp;/
                    <a href="/help">Documentation</a>
                    <div style="float:right">✪ ✪ ✪</div>
                </nav>
            </div>
            

            <? if ($content['page-type'] == 'page') { ?>
                <article>
                    <header>
                        <h2><?= h($content['page-title']) ?></h2>
                    </header>
                    <?= $content['page-body'] ?>
                </article>
            <? } else { 
                $count = 0;
                ?>
                
                <?= $content['page-type'] == 'year-archive' ? '<h2>' . $content['page-title'] . '</h2>' : '' ?>
                
                <? if (isset($content['posts'])) foreach ($content['posts'] as $post) { ?>
                    
                    <?= ($post['post-is-first-on-date'] && $content['page-type'] != 'post') ? '<div class="dateline">' . strftime('%A, %d %B %Y', $post['post-timestamp']) . '</div>' : '' ?>

                    <article<?= $post['post-type'] == 'link' ? ' class="link"' : '' ?>>
                        <?= $content['page-type'] == 'year-archive' ? '' : "<header>\n" ?>
<? if ($content['page-type'] == 'year-archive') { ?>
    <h3><a href="<?=  h($post['post-permalink']) ?>"><?= h($post['post-title']) ?></a></h3>
<? } else if ($content['page-type'] == 'post') {
    if ($post['post-type'] == 'link') { ?>
        <h2><a href="<?=  h($post['post-permalink-or-link']) ?>"><?= h($post['post-title']) ?></a></h2>
<?    } else { ?>
        <h2><?= h($post['post-title']) ?></h2>
<?    }
} else { 
    if ($post['post-type'] == 'link') { ?>
        <h2><a href="<?=  h($post['post-permalink-or-link']) ?>"><?= h($post['post-title']) ?></a>&nbsp;<a href="<?= h($post['post-permalink']) ?>" class="permalink">★</a></h2>
<?    } else { ?>
        <h2><a href="<?=  h($post['post-permalink-or-link']) ?>"><?= h($post['post-title']) ?></a></h2>
<? }
} 

if ($content['page-type'] != 'year-archive') { ?>
                <p class="post-date" datetime="<?= h(date('c', $post['post-timestamp'])) ?>" pubdate="pubdate"><?= strftime('%A, %d %B %Y', $post['post-timestamp']) ?></p>
                </header>
                
                <?= $post['post-body'] ?>
<? } ?>

                    </article>
                <? 
                $count++;
            } ?>
    <? } 
    
    if (!empty($content['archives'])) { ?>
            
<!-- Archive -->
<div id="archives">
<h3>Find more in the archives...</h3>
<div>
<?  $years = array();
    foreach ($content['archives'] as $archive) {
        $y = $archive['archives-year'];
        if (!isset($years[$y])) $years[$y] = array();
        $years[$y][] = $archive['archives-month-number'];
    }
    
    // 
    $tds = array(1 => 'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Ovt','Nov','Dec');
    foreach ($years as $year => $months) { 
        echo "<table>\n";
        echo '<tr><th colspan="4"><a href="/' . $year . '">' . $year . '</a></th></tr>' . "\n";
        echo '<tr>';
        for ($i = 1; $i < 13; $i++) {
            if (in_array($i, $months)) echo '<td><a href="/'. $year .'/'. str_pad($i, 2, '0', STR_PAD_LEFT) .'/">'. $tds[$i] .'</a></td>';
            else echo '<td>'. $tds[$i] .'</td>';
            if ($i % 4 == 0) {
                if ($i == 12) echo "</tr>\n";
                else echo "</tr>\n<tr>";
            }
        }
        echo "</table>\n\n";
    } ?>
</div>
</div>
<!-- Archive -->
<? } ?>            
            <footer>
                <p>&copy; Arif Muslax.</p>
                <p>
                    <a href="/rss.xml">RSS feed</a>. &bull; 
                    Powered by <a href="https://github.com/muslax/overcrack">Overcrack</a>.
                </p>
            </footer>
        </section>
    </body>
</html>
