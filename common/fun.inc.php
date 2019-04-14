<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/3/10
 * Time: 16:07
 */
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

function getApp() {
    if(isset($GLOBALS['app'])) {
        return $GLOBALS['app'];
    }else {
        return null;
    }
}
/**
 * 返回当前控制器
 */
function getClass() {
    $class = '';
    if($app = getApp()) {
        $class =  $app->getClass();
    }
    return $class;
}

/**
 * 返回当前方法
 */
function getAction() {
    $action = '';
    if($app = getApp()) {
        $action = $app->getAction();
    }
    return $action;
}

function guid() {
    $uuidFactory = new \Ramsey\Uuid\UuidFactory();
    $uuidFactory->setRandomGenerator(new \Ramsey\Uuid\Generator\RandomLibAdapter());
    Uuid::setFactory($uuidFactory);

    return Uuid::uuid4()->toString();
}

/**
 * 请求对象获取
 * @return \Symfony\Component\HttpFoundation\Request
 */
function request() {
    if(empty($GLOBALS['REQUEST']) || !$GLOBALS['REQUEST'] instanceof \Symfony\Component\HttpFoundation\Request) {
        $GLOBALS['REQUEST'] = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
    }
    return $GLOBALS['REQUEST'];
}

function _I($path) {
    include APP_ROOT . $path;
}

function _S($k, $v = null) {
    $GLOBALS['variables'][$k] = $v;
}

function _G($k) {
    return isset($GLOBALS['variables'][$k]) ? $GLOBALS['variables'][$k] : null;
}


/**
 * 获取请求数据
 * @param bool $k
 * @param null $default
 * @return mixed
 */
function _P($k = false, $default = null) {
    //todo:待优化
//    $request = request();
//    return $request->query->get($k, NULL);
    $req = request();
    if($req->query->has($k)) {
        return $req->query->get($k, $default);
    }else {
        return $req->request->get($k, $default);
    }
}

function _PI($k, $default = null) {
    return intval(_P($k, $default));
}

/*
 * 验证手机号
 */
function is_mobile($mobile) {
    return preg_match('/^1([38]\d|5[0-35-9]|7[3678])\d{8}$/', $mobile);
}

function is_email($email) {
    //todo:待优化
//    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    $partten = '#^(?:[a-z0-9!\#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!\#$%&\'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$#';
    return preg_match($partten, $email) != false;

}

function display_sub_menu($menus, $class) {
    $item1 = <<<foo
<li class="%s">
	<a href="%s">
		<i class="menu-icon fa fa-caret-right"></i>%s
    </a>
	<b class="arrow"></b>
</li>
foo;

    $item2 = <<<bar
<li class="">
    <a href="#" class="dropdown-toggle">
		<i class="menu-icon fa fa-caret-right"></i>%s
		<b class="arrow fa fa-angle-down"></b>
	</a>
	<b class="arrow"></b>
bar;
    $html = '<ul class="submenu">';
    foreach($menus as $k => $item) {
        if(isset($item['methods'])) {
            $html .= sprintf($item2, $item['title']);
            $html .= display_sub_menu($item['methods'], $class);
            $html .= '</li>';
        }else {
            $active = ((getAction() == $k) && (getClass() == $class)) ? 'active': '';
            $html .= sprintf($item1, $active, $item['url'], $item['title']);
        }
    }
    $html .= '</ul>';
    return $html;
}

//重定向
function redirect($url) {
    //todo:待优化
    header("Location: {$url}",TRUE,301);
    return false;
}