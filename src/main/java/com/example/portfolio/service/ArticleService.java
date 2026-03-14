package com.example.portfolio.service;

import com.example.portfolio.model.Article;
import com.example.portfolio.repository.ArticleRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.time.LocalDateTime;
import java.util.List;
import java.util.NoSuchElementException;

@Service
@RequiredArgsConstructor
@Transactional(readOnly = true)
public class ArticleService {
    private final ArticleRepository articleRepository;

    /** ブログ一覧（公開済みのみ・公開日時降順） */
    public List<Article> findPublished() {
        return articleRepository.findByStatusAndDeleteFlagOrderByPublishedAtDesc(
                Article.Status.published, 0);
    }

    /** 記事詳細（公開済みのみ） */
    public Article findPublishedById(Long id) {
        return articleRepository.findByIdAndStatusAndDeleteFlag(
                id, Article.Status.published, 0)
                .orElseThrow(() -> new NoSuchElementException("記事が見つかりません: " + id));
    }

    /** 管理画面用：全記事（下書き含む） */
    public List<Article> findAll() {
        return articleRepository.findByDeleteFlagOrderByUpdatedAtDesc(0);
    }

    /** 1件取得（管理画面用・下書き含む） */
    public Article findById(Long id) {
        return articleRepository.findById(id)
                .orElseThrow(() -> new NoSuchElementException("記事が見つかりません: " + id));
    }

    /** 保存（新規・更新共通） */
    @Transactional
    public Article save(Article article) {
        // status を published に変更した瞬間に published_at を設定
        if (article.getStatus() == Article.Status.published
                && article.getPublishedAt() == null) {
            article.setPublishedAt(LocalDateTime.now());
        }
        return articleRepository.save(article);
    }

    /** 論理削除 */
    @Transactional
    public void delete(Long id) {
        Article article = findById(id);
        article.setDeleteFlag(1);
        articleRepository.save(article);
    }
}
