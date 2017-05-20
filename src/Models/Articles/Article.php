<?php

namespace App\Models\Articles;

class Article extends \App\Models\BaseModel
{
    protected $table = 'articles';
    protected $column = ['id', 'user_id', 'title', 'title_slug', 'content', 'create_at', 'update_at', 'is_publish', 'publish_at', 'deleted'];
    protected $check = ['title_slug'];

    public function getAllJoin()
    {
        $article = $this->getAll()->fetchAll();

        if (!$article) {
            return false;
        }

        foreach ($article as $keyArticle => $valueArticle) {
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
            $article[$keyArticle]['category'][] = $valueCategory['category'];
            }

        }

        return $article;


    }
    public function add(array $data)
    {
        $add = [
            'user_id'       => $data['user_id'],
            'title'         => $data['title'],
            'title_slug'    => preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($data['title'])),
            'content'       => $data['content'],
            'is_publish'    => $data['is_publish'],
        ];

        if ($add['is_publish'] == 1) {
            $merge['publish_at'] = date('Y-m-d H:i:s');
        }
        $create = array_merge($add, $merge);

        return $this->checkOrCreate($create);
    }

    public function getEdit($slug)
    {
        $qb = $this->getBuilder();
        $article = $this->find('title_slug', $slug)->withoutDelete()->fetch();

        $categories = $qb->select('c.name as category')
           ->from('categories', 'c')
           ->innerJoin('c', 'article_category', 'ac', 'c.id = ac.category_id')
           ->innerJoin('ac', 'articles', 'a', 'ac.article_id = a.id')
           ->where('a.id = :id AND a.deleted = 0')
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
            'is_publish'    => $data['is_publish'],
        ];

        if ($edit['is_publish'] == 1) {
            $merge['publish_at'] = date('Y-m-d H:i:s');
            $edit = array_merge($edit, $merge);
        }

        $find = $this->find('title_slug', $slug)->withoutDelete()->fetch();

        if ($find['title'] == $edit['title']) {
            unset($edit['title']);
            unset($edit['title_slug']);
        }

        return $this->checkOrUpdate($edit, 'id', $find['id']);
    }

    public function getArticleByUserId($userId)
    {
        $article = $this->find('user_id', $userId)->withoutDelete()->fetchAll();

        if (!$article) {
            return false;
        }
        foreach ($article as $keyArticle => $valueArticle) {
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
            $article[$keyArticle]['category'][] = $valueCategory['category'];
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
        foreach ($article as $keyArticle => $valueArticle) {
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
            $article[$keyArticle]['category'][] = $valueCategory['category'];
            }

        }

        return $article;
    }

    public function showForUser(int $page, int $limit)
    {
        $qbArticle = $this->getBuilder();

        $this->query = $qbArticle->select('u.username, a.id, a.title, a.title_slug, a.content, a.publish_at')
                        ->from($this->table, 'a')
                        ->innerJoin('a', 'users', 'u', 'a.user_id = u.id')
                        ->where('a.is_publish = 1');

        $article = $this->withoutDelete()->paginate($page, $limit);

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

    public function showByCategory($category, int $page, int $limit)
    {
        $qbArticle = $this->getBuilder();

        $this->query = $qbArticle->select('u.username, a.id, a.title, a.title_slug, a.content, a.publish_at')
                        ->from($this->table, 'a')
                        ->innerJoin('a', 'users', 'u', 'a.user_id = u.id')
                        ->innerJoin('c', 'article_category', 'ac', 'c.id = ac.category_id')
                        ->innerJoin('ac', 'articles', 'a', 'ac.article_id = a.id')
                        ->where('a.is_publish = 1')
                        ->andWhere('c.name = :category')
                        ->setParameter(':category', $category);

        $article = $this->withoutDelete()->paginate($page, $limit);

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

    public function search($search, int $page, int $limit)
    {
        $qbArticle = $this->getBuilder();

        $this->query = $qbArticle->select('u.username, a.id, a.title, a.title_slug, a.content, a.publish_at')
                        ->from($this->table, 'a')
                        ->innerJoin('a', 'users', 'u', 'a.user_id = u.id')
                        ->where('a.is_publish = 1')
                        ->andWhere('a.title LIKE %'.$title.'%');

        $article = $this->withoutDelete()->paginate($page, $limit);

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

    public function getArticleBySlug($slug)
    {
        $qbArticle = $this->getBuilder();

        $this->query = $qbArticle->select('u.username, a.id, a.title, a.title_slug, a.content, a.publish_at')
                        ->from($this->table, 'a')
                        ->innerJoin('a', 'users', 'u', 'a.user_id = u.id')
                        ->where('a.is_publish = 1')
                        ->andWhere('a.title_slug = :title_slug')
                        ->setParameter(':title_slug', $slug);

        $article = $this->withoutDelete()->fetch();

        if (!$article) {
            return false;
        }

        foreach ($article as $keyArticle => $valueArticle) {
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
            $article['category'][] = $valueCategory['category'];
            }

        }

        return $article;
    }
}

?>
