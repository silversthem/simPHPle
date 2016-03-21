<?php
include 'config.php';
include_once 'app/classes/launcher.class.php';
spl_autoload_register(array('launcher','autoload'));

launcher::start_timer();

global $launcher;

$launcher = new launcher();

global $admin_permission;
$admin_permission = new \module\instructions\permission(\module\instructions\permission::SESSION_MATCHES,array('member','rank'),'admin');
global $moderator_permission;
$moderator_permission = new \module\instructions\permission(\module\instructions\permission::SESSION_MATCHES,array('member','rank'),'moderator');
global $user_permission;
$user_permission = new \module\instructions\permission(\module\instructions\permission::SESSION_MATCHES,array('member','rank'),'user');

$moderator_permission->add_friend($admin_permission);
$user_permission->add_friend($moderator_permission);

$index = new \routing\route('index');
$index->set_couple(array('index.html','index.php',''),'index.php');

$login = new \routing\route('login');
$login->set_couple('login','login.php');
$login->set_couple('register','register.php');
$login->set_couple('logout','logout.php',$user_permission);

$members = new \routing\route('members','member');
$members->files->add_file('index.php');
$members->set_couple('members/{?option}','memberlist.php');
$members->set_couple(array('member/{id}/{?option}'),'member.php');

$forum = new \routing\route('forum','forum/');
$forum->files->add_file('index.php');
$forum->set_couple('forum/{cat}','read.php');
$forum->set_couple('forum/{cat}/{option}','edit.php',$user_permission);
$forum->set_couple('forum/{cat}/{id}/{[topic]}','read_topic.php');

$simphple = new \routing\route('simphple','simphple/');
$simphple->files->add_file('index.php');
$simphple->set_couple('simphple/{option}','simphple.php');

$articles = new \routing\route('articles','articles/');
$articles->files->add_file('index.php');
$articles->set_couple('articles/','list.php');
$articles->set_couple('articles/{id}/{title}','read.php');
$articles->set_couple('articles/{option}','edit.php',$user_permission);

$wiki = new \routing\route('wiki','wiki/');
$wiki->files->add_file('index.php');
$wiki->set_couple('wiki/{entry}','wiki.php');
$wiki->set_couple('wiki/{option}/{entry}','edit.php',$user_permission);

$adminZone = new \routing\route('admin');
$adminZone->files->add_file('index.php');
$adminZone->set_couple('admin/{?module}/{?option}/{?1}/{?2}','admin.php',$admin_permission);
$adminZone->set_couple('moderation/{?module}/{?option}/{?1}/{?2}','moderation.php',$moderator_permission);
$adminZone->allow_display_module(false);

$style = \routing\route::simple_route('style','{[file]}.css');

$jscripts = \routing\route::simple_route('jscripts','{[file]}.js');

$upload = \routing\route::simple_route('upload','uploads/{[file]}');

$launcher->router->set_display_route($index,'display.php');
$launcher->load_module(launcher::AFTER_ROUTING,'style','index.php');
$launcher->router->add_routes($index,$login,$members,$forum,$articles,$simphple,$wiki,$adminZone,$style,$jscripts,$upload);

$launcher->run();

echo '<br/>'.launcher::stop_timer();
?>
