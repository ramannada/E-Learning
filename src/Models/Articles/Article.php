<?php

namespace App\Models\Articles;

class Article extends \App\Models\BaseModel
{
    protected $table = 'articles';
    protected $column = ['id', 'user_id', 'title', 'title_slug', 'content', 'create_at', 'update_at', 'deleted'];
    protected $check = ['title_slug'];

    public function add(array $data)
    {
        $data = [
            'user_id'       => $data['user_id'],
            'title'         => $data['title'],
            'title_slug'    => preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($data['title'])),
            'content'       => $data['content'],
        ];

        return $this->checkOrCreate($data);
    }

    public function getUpdateArticle($slug)
    {
        $qb = $this->getBuilder();
        $article = $this->find('title_slug', $slug)->fetch();

        $categories = $qb->select('c.name as category')
           ->from('categories', 'c')
           ->innerJoin('c', 'article_category', 'ac', 'c.id = ac.category_id')
           ->innerJoin('ac', 'articles', 'a', 'ac.article_id = a.id')
           ->where('a.id = :id')
           ->setParameter(':id', $article['id'])
           ->execute()
           ->fetchAll();

        foreach ($categories as $key => $value) {
            $category[] = $value['category'];
        }

        $article['category'] = $category;

        return $article;

    }

    public function edit($data, $slug)
    {
        $data = [
            'title'         => $data['title'],
            'title_slug'    => preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($data['title'])),
            'content'       => $data['content'],
        ];

        $find = $this->find('title_slug', $slug)->fetch();

        if ($find['title'] == $data['title']) {
            unset($data['title']);
            unset($data['title_slug']);
        }

        return $this->checkOrUpdate($data, 'title_slug', $slug);
    }
}

?>