package com.example.portfolio.repository;

import com.example.portfolio.model.Article;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;
import java.util.Optional;

/**
 * articles テーブルへのアクセス。
 */
public interface ArticleRepository extends JpaRepository<Article, Long> {
        /**
         * 公開済み記事を公開日時の降順で取得（ブログ一覧）。
         */
        List<Article> findByStatusAndDeleteFlagOrderByPublishedAtDesc(Article.Status status, int deleteFlag);

        /**
         * ID・ステータス・delete_flag で1件取得（記事詳細）。
         */
        Optional<Article> findByIdAndStatusAndDeleteFlag(Long id, Article.Status status, int deleteFlag);

        /**
         * 管理画面用：全記事を更新日時の降順で取得（下書き含む）。
         */
        List<Article> findByDeleteFlagOrderByUpdatedAtDesc(int deleteFlag);
}
