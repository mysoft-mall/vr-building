/**
 * 用于全局使用的Js脚本
 * Created by liuxh04 on 2016/6/30.
 */

"use strict";

var bindEvent = function(){
    $('body').on('click', '.btn-nav', function(){
        $(this).addClass('active').sibling('.btn-nav').removeClass('active');
    })
}();