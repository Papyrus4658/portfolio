package com.example.portfolio.model;

import jakarta.persistence.*;
import jakarta.validation.constraints.Email;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.Size;
import lombok.Getter;
import lombok.Setter;
import lombok.NoArgsConstructor;
import org.hibernate.annotations.CreationTimestamp;
import org.hibernate.annotations.UpdateTimestamp;

import java.time.LocalDateTime;

/**
 * users テーブルに対応するエンティティ。
 * PHP の login.php / register_account / quit / recover_account に相当。
 */
@Entity
@Table(name = "users")
@Getter
@Setter
@NoArgsConstructor
public class User {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    /** 表示名（edit_heading に相当） */
    @NotBlank
    @Size(max = 50)
    @Column(nullable = false, length = 50)
    private String username;

    /** ログインID（メールアドレス） */
    @NotBlank
    @Email
    @Size(max = 255)
    @Column(nullable = false, unique = true, length = 255)
    private String email;

    /** BCrypt ハッシュ化済みパスワード（Spring Security が照合） */
    @NotBlank
    @Column(name = "password_hash", nullable = false, length = 255)
    private String passwordHash;

    @CreationTimestamp
    @Column(name = "created_at", nullable = false, updatable = false)
    private LocalDateTime createdAt;

    @UpdateTimestamp
    @Column(name = "updated_at", nullable = false)
    private LocalDateTime updatedAt;

    /**
     * 論理削除フラグ。
     * 0 = 有効, 1 = 削除済み（PHP の hide_work / quit に相当）
     */
    @Column(name = "delete_flag", nullable = false)
    private int deleteFlag = 0;
}
