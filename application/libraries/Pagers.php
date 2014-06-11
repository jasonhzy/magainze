<?php
/**
 * Description of Pager
 * @author xiecl
 */
class Pagers {

    public $per_page = 10; //每页数量
    public $total_page = 2;   
    public $first = 1;
    public $slider = 3;
    public $prevLabel = '';
    public $length = 5;
    public $nextLabel = '';
    public $total_rows = 20;   //总数
    public $current = 1;
    public $base_url = '';

    function __construct() {
        $this->object = & get_instance();  
    }

    function outputhtml() {
        $this->total_page=ceil($this->total_rows / $this->per_page);
        $perpage = $this->per_page;
        $last = $this->total_page;
        $prev = $this->current - 1; //
        $next = $this->current + 1;    //下一页
        $output = "<ul class='pagenav'>";
        if ($this->current == $this->first) {
            $output .= "<li style='width:45px;'   class=\"disabled current be\">首页" . $this->prevLabel . "</li>";
        } else {
            $output .= "<li style='width:45px;' class='be'><a href='" . $this->base_url ."1'>首页" . $this->prevLabel . "</a></li>";
        }
        $mid = intval($this->length / 2);
        if ($this->current < $this->first) {
            $this->current = $this->first;
        }
        if ($this->current > $last) {
            $this->current = $last;
        }
        $begin = $this->current - $mid; //-1
        if ($begin < $this->first) {
            $begin = $this->first;
        }
        $end = $begin + $this->length + 1; //7
        if ($end >= $last) {
            $end = $last;
            $begin = $end - $this->length - 1;
            if ($begin < $this->first) {
                $begin = $this->first;
            }
        }
        if ($begin > $this->first) {
            for ($i = $this->first - 1; $i < $this->first + $this->slider && $i < $begin; $i++) {
                $page = $i + 1;
                $in = $i + 1;
                $urls = $this->base_url . $page;
                $output .= "<li><a href=\"{$urls}\">{$in}</a></li>";
            }
            if ($i < $begin) {
                $output .= "<li class=\"none\">...</li>";
            }
        }
        for ($i = $begin; $i < $end + 1; $i++) {
            $page = $i;
            $in = $i;
            if ($i == $this->current) {
                $output .= "<li class=\"current\">{$in}</li>";
            } else {
                $urls = $this->base_url . $page;
                $output .= "<li><a href=\"{$urls}\">{$in}</a></li>";
            }
        }
        if ($last - $end > $this->slider) {
            $output .= "<li class=\"none\">...</li>";
            $end = $last - $this->slider;
        }
        for ($i = $end + 1; $i < $last; $i++) {
            $page = $i + 1;
            $in = $i + 1;
            $urls = $this->base_url . $page;
            $output .= "<li><a href=\"{$urls}\">{$in}</a></li>";
        }
        if ($this->current == $last) {
            $output .= "<li style='width:45px;'  class=\"disabled current be\">" . $this->nextLabel . " 尾页</li>";
        } else {
            $page = $last;
            $urls = $this->base_url . $page;
            $output .= "<li style='width:45px;' class='be'><a href=\"{$urls}\">" . $this->nextLabel . " 尾页</a></li>";
        }
        $output .= "</ul>";
        if ($this->total_rows == 0) {
            $output = '';
        }
        return $output;
    }
}