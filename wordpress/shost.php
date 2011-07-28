<?php
/*
Plugin Name: shost
Plugin URI: http://scalingexcellence.co.uk/secure-facebook-ssl-hosting
Description: Plugin for interfacing a node server delivering hostnames
Author: http://scalingexcellence.co.uk/secure-facebook-ssl-hosting
Author URI: http://scalingexcellence.co.uk/secure-facebook-ssl-hosting
Version: 1.0
*/

if ( preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF']) ) { die('You are not allowed to call this page directly.'); }

define( 'SHOST_VERSION', '1.0' );

define( 'SHOST_DIR', str_replace("\\", '/', dirname(__FILE__)) );
$path = explode('/', SHOST_DIR);
define( 'SHOST_DIRNAME', $path[count($path)-1] );
define( 'SHOST_URL', WP_PLUGIN_URL.'/'.str_replace('/'.basename(__FILE__), '', plugin_basename(__FILE__)) );


function shost_func($atts) {
    return <<<EOT
    
    <form id="shost">URL: <input type="text" name="url" id="url" /><input type="submit" value="Check" /></form>
    <div id="results"></div>

    <script type="text/javascript">/* <![CDATA[ */
    (function($) {
        \$(function() {
            \$('#shost').submit(function() {
                \$.getJSON("http://78.47.228.218:4233/?callback=?", \$(this).serialize() ,function(re) {
                    var color="#0C0";
                    if (re.type == 3 || re.type==4) {
                        color="#C00";
                    }
                    f=function(){}
                    v = "<span style='color:"+color+"'>"+re.message+"!</span> "
                    if (re.dom!='') {
                        v+="You can find your secure facebook url on: <span id='vxdom' style='color:#00C'/>";
                        f=function() {\$("#vxdom").text(re.dom);};
                    }
                    \$("#results").html(v);
                    f();
                })
                \$("#results").html("<img src='data:image/gif;base64, \
                    R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH+GkNyZWF0ZWQgd2l0aCBhamF4 \
                    bG9hZC5pbmZvACH5BAAKAAAAIf8LTkVUU0NBUEUyLjADAQAAACwAAAAAEAAQAAADMwi63P4wyklr \
                    E2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQACgABACwAAAAA \
                    EAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUk \
                    KhIAIfkEAAoAAgAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9 \
                    HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkEAAoAAwAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYum \
                    CYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkEAAoABAAsAAAAABAAEAAAAzII \
                    unInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQACgAF \
                    ACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJ \
                    ibufbSlKAAAh+QQACgAGACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFG \
                    xTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAAKAAcALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdce \
                    CAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==' alt='loading' />");
                return false;
            });
        });
    })(jQuery);
    /* ]]> */</script>

EOT;
}

wp_enqueue_script( 'jquery' );

add_shortcode('shost', 'shost_func');
