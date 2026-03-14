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
 * projects テーブルに対応するエンティティ。
 * PHP の add_work / details / hide_work に相当。
 */
@Entity
@Table(name = "projects")
@Getter
@Setter
@NoArgsConstructor
public class Project {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    /** 作品名 */
    @NotBlank
    @Size(max = 100)
    @Column(nullable = false, length = 100)
    private String title;

    /** 概要 */
    @Column(columnDefinition = "TEXT")
    private String description;

    /** サムネイル画像 URL */
    @Column(name = "thumbnail_url", length = 500)
    private String thumbnailUrl;

    /** リポジトリ URL（Codeberg / GitHub など） */
    @Column(name = "repository_url", length = 500)
    private String repositoryUrl;

    /** デモサイト URL（任意） */
    @Column(name = "demo_url", length = 500)
    private String demoUrl;

    /** 使用技術（例: "Java, Spring Boot, MySQL"） */
    @Column(name = "tech_stack", length = 255)
    private String techStack;

    /** ギャラリーの表示順（昇順） */
    @Column(name = "sort_order", nullable = false)
    private int sortOrder = 0;

    @CreationTimestamp
    @Column(name = "created_at", nullable = false, updatable = false)
    private LocalDateTime createdAt;

    @UpdateTimestamp
    @Column(name = "updated_at", nullable = false)
    private LocalDateTime updatedAt;

    /** 論理削除フラグ。hide_work に相当。0 = 公開, 1 = 非表示 */
    @Column(name = "delete_flag", nullable = false)
    private int deleteFlag = 0;
}
