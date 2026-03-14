package com.example.portfolio.service;

import com.example.portfolio.model.User;
import com.example.portfolio.repository.UserRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.NoSuchElementException;

/**
 * ユーザー管理のビジネスロジック。
 * PHP の register_account / quit / recover_account / edit_heading に相当。
 */
@Service
@RequiredArgsConstructor
@Transactional(readOnly = true)
public class UserService {

    private final UserRepository userRepository;
    private final PasswordEncoder passwordEncoder;

    /**
     * 新規ユーザー登録（PHP の register_account に相当）。
     * パスワードは BCrypt でハッシュ化して保存する。
     *
     * @throws IllegalArgumentException メールアドレス重複時
     */
    @Transactional
    public User register(String username, String email, String rawPassword) {
        if (userRepository.existsByEmail(email)) {
            throw new IllegalArgumentException("このメールアドレスはすでに登録されています。");
        }
        User user = new User();
        user.setUsername(username);
        user.setEmail(email);
        user.setPasswordHash(passwordEncoder.encode(rawPassword));
        return userRepository.save(user);
    }

    /**
     * 表示名の変更（PHP の edit_heading に相当）。
     */
    @Transactional
    public void updateUsername(Long userId, String newUsername) {
        User user = userRepository.findById(userId)
                .orElseThrow(() -> new NoSuchElementException("ユーザーが見つかりません"));
        user.setUsername(newUsername);
        userRepository.save(user);
    }

    /**
     * 論理削除（PHP の quit に相当）。
     * delete_flag = 1 にすることでログイン不可になる（SecurityConfig 参照）。
     */
    @Transactional
    public void withdraw(Long userId) {
        User user = userRepository.findById(userId)
                .orElseThrow(() -> new NoSuchElementException("ユーザーが見つかりません"));
        user.setDeleteFlag(1);
        userRepository.save(user);
    }

    /**
     * アカウント復元（PHP の recover_account に相当）。
     * delete_flag を 0 に戻す。
     */
    @Transactional
    public void recover(String email) {
        User user = userRepository.findByEmail(email)
                .orElseThrow(() -> new NoSuchElementException("ユーザーが見つかりません"));
        user.setDeleteFlag(0);
        userRepository.save(user);
    }
}
