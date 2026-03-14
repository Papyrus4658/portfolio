package com.example.portfolio.repository;

import com.example.portfolio.model.User;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.Optional;

/**
 * users テーブルへのアクセス。
 * JpaRepository を継承するだけで基本 CRUD が自動生成される。
 */
public interface UserRepository extends JpaRepository<User, Long> {

    /** メールアドレスでユーザーを検索（ログイン認証で使用） */
    Optional<User> findByEmail(String email);

    /** 有効なユーザーをメールアドレスで検索（delete_flag = 0） */
    Optional<User> findByEmailAndDeleteFlag(String email, int deleteFlag);

    /** メールアドレスの重複確認（新規登録時） */
    boolean existsByEmail(String email);
}
