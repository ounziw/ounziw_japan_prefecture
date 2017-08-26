<?php  defined('C5_EXECUTE') or die("Access Denied.");
// This template displays Japan prefecture topics as a Japan Map.

// The links display via $linkoutput
// See $linkoutput

// The selected topics display with a class "selected"
// See $linkselected

// td に title 属性をつければ、ツールチップが出る
// aタグをセル全体にしたい＝＞tdの高さ、幅を指定
?>

<div class="ccm-block-topic-list-wrapper">
<?php if($title):?>
    <div class="ccm-block-topic-list-header">
        <h5><?php echo h($title); ?></h5>
    </div>
<?php endif;?>
<?php
$links = array(array('url' => '', 'title' => '', 'selected' => false));
$linkoutput = function() {};
$linkselected = function() {};
if ($mode == 'S' && is_object($tree)) {
    $node = $tree->getRootTreeNodeObject();
    $node->populateChildren();
    if (is_object($node)) {
        if (!isset($selectedTopicID)) {
            $selectedTopicID = null;
        }
        $selected = false;
        $walk = function ($node) use (&$links, &$walk, &$view, $selectedTopicID) {
            foreach ($node->getChildNodes() as $topic) {
                if ($topic instanceof \Concrete\Core\Tree\Node\Type\Category) {
                    // ignore the categories, since they do not appear in the Japan Map.
                } else {
                    if (isset($selectedTopicID) && $selectedTopicID == $topic->getTreeNodeID()) {
                        $selected = true;
                    } else {
                        $selected = false;
                    }
                    $links[] = array(
                        'url' => (string) $view->controller->getTopicLink($topic),
                        'title' => $topic->getTreeNodeDisplayName(),
                        'selected' => $selected,
                    );
                }
                if (count($topic->getChildNodes())) {
                    $walk($topic);
                }
            }
        };
        $walk($node);
    }
    $linkoutput = function ($prefid) use ($links) {
        if ($prefid >= 1 && $prefid <= 47) {
            echo '<a href="' . Core::make('helper/security')->sanitizeURL($links[$prefid]['url']) . '">';
            echo '&nbsp;';
            echo '</a>';
        }
    };

    $linkselected = function ($prefid) use ($links) {
        if ($prefid >= 1 && $prefid <= 47) {
            if ($links[$prefid]['selected']) {
                echo 'selected ';
            }
        }
    };
}
if ($mode == 'P') {
    if (count($topics)) {

        $selectedarray = array();
        foreach ($topics as $newtopic) {
            $selectedarray[] = $newtopic->getTreeNodeID();
        }
        $tID = $topics[0]->getTreeID();
        $tt = new \Concrete\Core\Tree\Type\Topic();
        $tree = $tt->getByID(Core::make('helper/security')->sanitizeInt($tID));
        $node = $tree->getRootTreeNodeObject();
        $node->populateChildren();
        if (is_object($node)) {
            $selected = false;
            $walk = function ($node) use (&$links, &$walk, &$view, $selectedTopicID, $selectedarray) {
                foreach ($node->getChildNodes() as $topic) { ?>
                    <?php
                    if ($topic instanceof \Concrete\Core\Tree\Node\Type\TopicCategory) {

                    } else {
                        if (in_array($topic->getTreeNodeID(),$selectedarray)) {
                            $selected = true;
                        } else {
                            $selected = false;
                        }
                        $links[] = array(
                            'url' => (string) $view->controller->getTopicLink($topic),
                            'title' => $topic->getTreeNodeDisplayName(),
                            'selected' => $selected,
                        );
                    }
                    if (count($topic->getChildNodes())) {
                        $walk($topic);
                    }
                }
            };
            $walk($node);
        }
        $linkoutput = function ($prefid) use ($links) {
            if ($prefid >= 1 && $prefid <= 47) {
                //echo '<a href="' . Core::make('helper/security')->sanitizeURL($links[$prefid]['url']) . '">';
                echo h($links[$prefid]['title']);
                //echo '</a>';
            }
        };

        $linkselected = function ($prefid) use ($links) {
            if ($prefid >= 1 && $prefid <= 47) {
                if ($links[$prefid]['selected']) {
                    echo 'selected ';
                }
            }
        };
    }
}

if (is_object($tree)) {
    // Japan map, using HTML table
    ?>
    <table id="map1" class="tablemap">
        <tr>
            <td colspan="1" rowspan="16" class="sea frame"> </td>
            <td colspan="16" class="sea frame"> </td>
            <td colspan="1" rowspan="16" class="sea frame"> </td>
        </tr>
        <tr>
            <td colspan="14" rowspan="4" class="sea"></td>
            <td colspan="2" title="<?php echo t('Hokkaido');?>" class="land c01 <?php $linkselected(1);?>cr01"><?php $linkoutput(1);?></td>
        </tr>
        <tr><td colspan="2" class="sea frame"> </td></tr>
        <tr>
            <td colspan="2" title="<?php echo t('Aomori');?>" class="land c02 <?php $linkselected(2);?>cr01"><?php $linkoutput(2);?></td>
        </tr>
        <tr>
            <td title="<?php echo t('Akita');?>" class="land c05 <?php $linkselected(5);?>cr01"><?php $linkoutput(5);?></td>
            <td title="<?php echo t('Iwate');?>" class="land c03 <?php $linkselected(3);?>cr01"><?php $linkoutput(3);?></td>
        </tr>
        <tr>
            <td colspan="10" rowspan="2" class="sea"></td>
            <td rowspan="2" title="<?php echo t('Ishikawa');?>" class="land c17 <?php $linkselected(17);?>cr03"><?php $linkoutput(17);?></td>
            <td colspan="3" class="sea"></td>
            <td title="<?php echo t('Yamagata');?>" class="land c06 <?php $linkselected(6);?>cr01"><?php $linkoutput(6);?></td>
            <td title="<?php echo t('Miyagi');?>" class="land c04 <?php $linkselected(4);?>cr01"><?php $linkoutput(4);?></td>
        </tr>
        <tr>
            <td title="<?php echo t('Toyama');?>" class="land c16 <?php $linkselected(16);?>cr03"><?php $linkoutput(16);?></td>
            <td colspan="2" title="<?php echo t('Niigata');?>" class="land c15 <?php $linkselected(15);?>cr03"><?php $linkoutput(15);?></td>
            <td colspan="2" title="<?php echo t('Fukushima');?>" class="land c07 <?php $linkselected(7);?>cr01"><?php $linkoutput(7);?></td>
        </tr>
        <tr>
            <td colspan="9" class="sea"></td>
            <td colspan="2" title="<?php echo t('Fukui');?>" class="land c18 <?php $linkselected(18);?>cr03"><?php $linkoutput(18);?></td>
            <td rowspan="2" title="<?php echo t('Gifu');?>" class="land c21 <?php $linkselected(21);?>cr04"><?php $linkoutput(21);?></td>
            <td rowspan="2" title="<?php echo t('Nagano');?>" class="land c20 <?php $linkselected(20);?>cr03"><?php $linkoutput(20);?></td>
            <td title="<?php echo t('Gunma');?>" class="land c10 <?php $linkselected(10);?>cr02"><?php $linkoutput(10);?></td>
            <td title="<?php echo t('Tochigi');?>" class="land c09 <?php $linkselected(9);?>cr02"><?php $linkoutput(9);?></td>
            <td rowspan="2" title="<?php echo t('Ibaraki');?>" class="land c08 <?php $linkselected(8);?>cr02"><?php $linkoutput(8);?></td>
        </tr>
        <tr>
            <td colspan="4" class="sea"></td>
            <td title="<?php echo t('Yamaguchi');?>" class="land c35 <?php $linkselected(35);?>cr06"><?php $linkoutput(35);?></td>
            <td title="<?php echo t('Shimane');?>" class="land c32 <?php $linkselected(32);?>cr06"><?php $linkoutput(32);?></td>
            <td title="<?php echo t('Tottori');?>" class="land c31 <?php $linkselected(31);?>cr06"><?php $linkoutput(31);?></td>
            <td rowspan="2" title="<?php echo t('Hyogo');?>" class="land c28 <?php $linkselected(28);?>cr05"><?php $linkoutput(28);?></td>
            <td title="<?php echo t('Kyoto');?>" class="land c26 <?php $linkselected(26);?>cr05"><?php $linkoutput(26);?></td>
            <td colspan="2" title="<?php echo t('Shiga');?>" class="land c25 <?php $linkselected(25);?>cr05"><?php $linkoutput(25);?></td>
            <td colspan="2" title="<?php echo t('Saitama');?>" class="land c11 <?php $linkselected(11);?>cr02"><?php $linkoutput(11);?></td>
        </tr>
        <tr>
            <td rowspan="2" title="<?php echo t('Nagasaki');?>" class="land c42 <?php $linkselected(42);?>cr08"><?php $linkoutput(42);?></td>
            <td rowspan="2" title="<?php echo t('Saga');?>" class="land c41 <?php $linkselected(41);?>cr08"><?php $linkoutput(41);?></td>
            <td colspan="2" title="<?php echo t('Fukuoka');?>" class="land c40 <?php $linkselected(40);?>cr08"><?php $linkoutput(40);?></td>
            <td rowspan="5" class="sea"></td>
            <td title="<?php echo t('Hiroshima');?>" class="land c34 <?php $linkselected(34);?>cr06"><?php $linkoutput(34);?></td>
            <td title="<?php echo t('Okayama');?>" class="land c33 <?php $linkselected(33);?>cr06"><?php $linkoutput(33);?></td>
            <td title="<?php echo t('Osaka');?>" class="land c27 <?php $linkselected(27);?>cr05"><?php $linkoutput(27);?></td>
            <td title="<?php echo t('Nara');?>" class="land c29 <?php $linkselected(29);?>cr05"><?php $linkoutput(29);?></td>
            <td rowspan="2" title="<?php echo t('Mie');?>" class="land c24 <?php $linkselected(24);?>cr04"><?php $linkoutput(24);?></td>
            <td title="<?php echo t('Aichi');?>" class="land c23 <?php $linkselected(23);?>cr04"><?php $linkoutput(23);?></td>
            <td rowspan="2" title="<?php echo t('Shizuoka');?>" class="land c22 <?php $linkselected(22);?>cr04"><?php $linkoutput(22);?></td>
            <td title="<?php echo t('Yamanashi');?>" class="land c19 <?php $linkselected(19);?>cr03"><?php $linkoutput(19);?></td>
            <td title="<?php echo t('Tokyo');?>" class="land c13 <?php $linkselected(13);?>cr02"><?php $linkoutput(13);?></td>
            <td rowspan="2" title="<?php echo t('Chiba');?>" class="land c12 <?php $linkselected(12);?>cr02"><?php $linkoutput(12);?></td>
        </tr>
        <tr>
            <td rowspan="2" title="<?php echo t('Kumamoto');?>" class="land c43 <?php $linkselected(43);?>cr08"><?php $linkoutput(43);?></td>
            <td title="<?php echo t('Oita');?>" class="land c44 <?php $linkselected(44);?>cr08"><?php $linkoutput(44);?></td>
            <td colspan="3" class="sea"></td>
            <td colspan="2" title="<?php echo t('Wakayama');?>" class="land c30 <?php $linkselected(30);?>cr05"><?php $linkoutput(30);?></td>
            <td class="sea"></td>
            <td title="<?php echo t('Kanagawa');?>" class="land c14 <?php $linkselected(14);?>cr02"><?php $linkoutput(14);?></td>
            <td class="sea"></td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2" class="sea"></td>
            <td rowspan="1" title="<?php echo t('Miyazaki');?>" class="land c45 <?php $linkselected(45);?>cr08"><?php $linkoutput(45);?></td>
            <td title="<?php echo t('Ehime');?>" class="land c38 <?php $linkselected(38);?>cr07"><?php $linkoutput(38);?></td>
            <td title="<?php echo t('Kagawa');?>" class="land c37 <?php $linkselected(37);?>cr07"><?php $linkoutput(37);?></td>
            <td rowspan="3" colspan="9" class="sea"></td>
        </tr>
        <tr>
            <td colspan="2" title="<?php echo t('Kagoshima');?>" class="land c46 <?php $linkselected(46);?>cr08"><?php $linkoutput(46);?></td>
            <td title="<?php echo t('Kochi');?>" class="land c39 <?php $linkselected(39);?>cr07"><?php $linkoutput(39);?></td>
            <td title="<?php echo t('Tokushima');?>" class="land c36 <?php $linkselected(36);?>cr07"><?php $linkoutput(36);?></td>
        </tr>
        <tr>
            <td colspan="16" class="sea frame"> </td>
        </tr>
        <tr>
            <td title="<?php echo t('Okinawa');?>" class="land c47 <?php $linkselected(47);?>cr08"><?php $linkoutput(47);?></td>
            <td colspan="15" class="sea"></td>
        </tr>
        <tr>
            <td colspan="16" class="sea frame"> </td>
        </tr>
    </table>
<?php
} else {
    echo t('No topics.');
}
?>
</div>
