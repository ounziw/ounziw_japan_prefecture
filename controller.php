<?php
namespace Concrete\Package\OunziwJapanPrefecture;

use \Concrete\Core\Package\Package;
use \Concrete\Core\Tree\Type\Topic as TopicTree;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends Package {
    protected $pkgHandle = 'ounziw_japan_prefecture';
    protected $appVersionRequired = '8.2';
    protected $pkgVersion = '0.9.2';
    public function getPackageDescription() {
        return t("Adds a topic for Japan Prefectures.");
    }
    public function getPackageName() {
        return t("Rescuework's Japan Prefecture");
    }
    public function install() {
        $pkg = parent::install();
        $this->importPrefecture();
    }

    protected function importPrefecture() {
        $xml_data = <<<EOT
<?xml version="1.0"?>
    <tree type="topic" name="Prefecture">
        <category name="Hokkaido Tohoku" default="1">
            <topic name="Hokkaido"/>
            <topic name="Aomori"/>
            <topic name="Iwate"/>
            <topic name="Miyagi"/>
            <topic name="Akita"/>
            <topic name="Yamagata"/>
            <topic name="Fukushima"/>
        </category>
        <category name="Kanto" default="1">
            <topic name="Ibaraki"/>
            <topic name="Tochigi"/>
            <topic name="Gunma"/>
            <topic name="Saitama"/>
            <topic name="Chiba"/>
            <topic name="Tokyo"/>
            <topic name="Kanagawa"/>
        </category>
        <category name="Chubu" default="1">
            <topic name="Niigata"/>
            <topic name="Toyama"/>
            <topic name="Ishikawa"/>
            <topic name="Fukui"/>
            <topic name="Yamanashi"/>
            <topic name="Nagano"/>
            <topic name="Gifu"/>
            <topic name="Shizuoka"/>
            <topic name="Aichi"/>
        </category>
        <category name="Kinki" default="1">
            <topic name="Mie"/>
            <topic name="Shiga"/>
            <topic name="Kyoto"/>
            <topic name="Osaka"/>
            <topic name="Hyogo"/>
            <topic name="Nara"/>
            <topic name="Wakayama"/>
        </category>
        <category name="Chugoku" default="1">
            <topic name="Tottori"/>
            <topic name="Shimane"/>
            <topic name="Okayama"/>
            <topic name="Hiroshima"/>
            <topic name="Yamaguchi"/>
        </category>
        <category name="Shikoku" default="1">
            <topic name="Tokushima"/>
            <topic name="Kagawa"/>
            <topic name="Ehime"/>
            <topic name="Kochi"/>
        </category>
        <category name="Kyushu Okinawa" default="1">
            <topic name="Fukuoka"/>
            <topic name="Saga"/>
            <topic name="Nagasaki"/>
            <topic name="Kumamoto"/>
            <topic name="Oita"/>
            <topic name="Miyazaki"/>
            <topic name="Kagoshima"/>
            <topic name="Okinawa"/>
        </category>
    </tree>
EOT;
        $xml = simplexml_load_string($xml_data);
        TopicTree::import($xml);
    }
}