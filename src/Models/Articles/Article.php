<?php

namespace App\Models\Articles;

class Article extends \App\Models\BaseModel
{
    protected $table = 'articles';
    protected $column = ['id', 'user_id', 'title', 'title_slug', 'content', 'create_at', 'update_at', 'deleted'];
    protected $check = ['title_slug'];

    public function getAllJoin($page, $limit)
    {
        $article = $this->getAll()->paginate($page, $limit);

        if (!$article) {
            return false;
        }

        foreach ($article['data'] as $keyArticle => $valueArticle) {
            $qb = $this->getBuilder();

            $categories = $qb->select('c.name as category')
               ->from('categories', 'c')
               ->innerJoin('c', 'article_category', 'ac', 'c.id = ac.category_id')
               ->innerJoin('ac', 'articles', 'a', 'ac.article_id = a.id')
               ->where('a.id = :id')
               ->setParameter(':id', $valueArticle['id'])
               ->execute()
               ->fetchAll();

            foreach ($categories as $keyCategory => $valueCategory) {
            $article['data'][$keyArticle]['category'][] = $valueCategory['category'];
            }

        }
        
        return $article;


    }
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

    public function getEdit($slug)
    {
        $qb = $this->getBuilder();
        $article = $this->find('title_slug', $slug)->withoutDelete()->fetch();

        $categories = $qb->select('c.name as category')
           ->from('categories', 'c')
           ->innerJoin('c', 'article_category', 'ac', 'c.id = ac.category_id')
           ->innerJoin('ac', 'articles', 'a', 'ac.article_id = a.id')
           ->where('a.id = :id AND deleted = 0')
           ->setParameter(':id', $article['id'])
           ->execute()
           ->fetchAll();

        foreach ($categories as $key => $value) {
            $category[] = $value['category'];
        }

        $article['category'] = $category;

        if (!$article['category']) {
            return false;
        }

        return $article;

    }

    public function edit($data, $slug)
    {
        $edit = [
            'title'         => $data['title'],
            'title_slug'    => preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($data['title'])),
            'content'       => $data['content'],
        ];

        $find = $this->find('title_slug', $slug)->withoutDelete()->fetch();

        if ($find['title'] == $edit['title']) {
            unset($edit['title']);
            unset($edit['title_slug']);
        }

        return $this->checkOrUpdate($edit, 'id', $find['id']);
    }

    public function getArticleByUserId($userId, int $page, int $limit)
    {
        $article = $this->find('user_id', $userId)->withoutDelete()->paginate($page, $limit);

        if (!$article) {
            return false;
        }
        foreach ($article['data'] as $keyArticle => $valueArticle) {
            $qb = $this->getBuilder();

            $categories = $qb->select('c.name as category')
               ->from('categories', 'c')
               ->innerJoin('c', 'article_category', 'ac', 'c.id = ac.category_id')
               ->innerJoin('ac', 'articles', 'a', 'ac.article_id = a.id')
               ->where('a.id = :id AND a.deleted = 0')
               ->setParameter(':id', $valueArticle['id'])
               ->execute()
               ->fetchAll();

            foreach ($categories as $keyCategory => $valueCategory) {
            $article['data'][$keyArticle]['category'][] = $valueCategory['category'];
            }

        }
        
        return $article;
    }

    public function getTrashByUserId($userId)
    {
        $article = $this->find('user_id', $userId)->withDelete()->fetchAll();

        if (!$article) {
            return false;
        }
        foreach ($article['data'] as $keyArticle => $valueArticle) {
            $qb = $this->getBuilder();

            $categories = $qb->select('c.name as category')
               ->from('categories', 'c')
               ->innerJoin('c', 'article_category', 'ac', 'c.id = ac.category_id')
               ->innerJoin('ac', 'articles', 'a', 'ac.article_id = a.id')
               ->where('a.id = :id AND a.deleted = 1')
               ->setParameter(':id', $valueArticle['id'])
               ->execute()
               ->fetchAll();

            foreach ($categories as $keyCategory => $valueCategory) {
            $article['data'][$keyArticle]['category'][] = $valueCategory['category'];
            }

        }
        
        return $article;
    }
}

?>