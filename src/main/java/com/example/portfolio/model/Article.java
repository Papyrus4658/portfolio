package com.example.portfolio.model;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.Size;
import lombok.Getter;
import lombok.Setter;
import lombok.NoArgsConstructor;
import org.hibernate.annotations.CreationTimestamp;
import org.hibernate.annotations.UpdateTimestamp;

import java.time.LocalDateTime;

/**
 * articles テーブルに対応するエンティティ。
 * ブログ記事の管理（下書き・公開）を担う。
 */
@Entity
@Table(name = "articles")
@Getter
@Setter
@NoArgsConstructor
public class Article {

    /** 記事のステータス */
    public enum Status {
        draft, published
    }

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @NotBlank
    @Size(max = 200)
    @Column(nullable = false, length = 200)
    private String title;

    /** 本文（Markdown 形式を想定） */
    @Column(columnDefinition = "LONGTEXT")
    private String content;

    @Column(name = "thumbnail_url", length = 500)
    private String thumbnailUrl;

    /**
     * 公開ステータス。
     * draft（下書き）/ published（公開）
     */
    @Enumerated(EnumType.STRING)
    @Column(nullable = false, length = 20)
    private Status status = Status.draft;

    /** 公開日時。status を published に変更した時点で自動設定する */
    @Column(name = "published_at")
    private LocalDateTime publishedAt;

    @CreationTimestamp
    @Column(name = "created_at", nullable = false, updatable = false)
    private LocalDateTime createdAt;

    @UpdateTimestamp
    @Column(name = "updated_at", nullable = false)
    private LocalDateTime updatedAt;

    /** 論理削除フラグ。0 = 有効, 1 = 削除済み */
    @Column(name = "delete_flag", nullable = false)
    private int deleteFlag = 0;
}
