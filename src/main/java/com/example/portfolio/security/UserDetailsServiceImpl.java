package com.example.portfolio.security;

import com.example.portfolio.model.User;
import com.example.portfolio.repository.UserRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.stereotype.Service;

/**
 * Spring Security がログイン時に呼び出すユーザー検索サービス。
 * PHP の login.php の SELECT + password_verify に相当。
 */
@Service
@RequiredArgsConstructor
public class UserDetailsServiceImpl implements UserDetailsService {
    private final UserRepository userRepository;

    /**
     * メールアドレスでユーザーを検索する。
     * 論理削除済み（delete_flag = 1）のユーザーはログイン不可。
     *
     * @param email ログインフォームに入力されたメールアドレス
     * @throws UsernameNotFoundException 該当ユーザーが存在しない場合
     */
    @Override
    public UserDetails loadUserByUsername(String email) throws UsernameNotFoundException {
        User user = userRepository.findByEmailAndDeleteFlag(email, 0)
                .orElseThrow(() -> new UsernameNotFoundException("ユーザーが見つかりません: " + email));

        return org.springframework.security.core.userdetails.User
                .withUsername(user.getEmail())
                .password(user.getPasswordHash()) // BCrypt ハッシュ
                .roles("USER")
                .build();
    }
}
