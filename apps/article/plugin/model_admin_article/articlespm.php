<?php

class plugin_articlespm extends object
{
    private $article;

    public function __construct($article)
    {
        $this->article = $article;
    }

    public function after_add()
    {
        $this->articlespm();
    }

    public function after_edit()
    {
        $this->articlespm();
    }

    public function after_publish()
    {
        $this->articlespm();
    }

    public function after_pass()
    {
        $this->articlespm();
    }

    private function articlespm()
    {
        if($this->article->data['status'] != 6) return; //状态不等于发布时跳出
        if(config('articlespm', 'catid')) {
            $catids = explode(',', $this->article->category[$this->article->data['catid']]['parentids']);
            array_push($catids, $this->article->data['catid']);
            if(!array_intersect($catids, config('articlespm', 'catid'))) return;
        }
        factory::queue('articlespm')->add($this->article->data); //数据加入队列
        return;
    }
}
