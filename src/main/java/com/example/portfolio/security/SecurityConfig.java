package com.example.portfolio.security;

import lombok.RequiredArgsConstructor;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.security.web.SecurityFilterChain;

/**
 * Spring Security の設定。
 * PHP の login.php / logout.php / session_start() に相当する処理を一元管理。
 */
@Configuration
@EnableWebSecurity
@RequiredArgsConstructor
public class SecurityConfig {
    private final UserDetailsServiceImpl userDetailsService;

    /**
     * パスワードハッシュ化に BCrypt を使用。
     * PHP の password_hash($pass, PASSWORD_BCRYPT) / password_verify() に相当。
     */
    @Bean
    public PasswordEncoder passwordEncoder() {
        return new BCryptPasswordEncoder();
    }

    @Bean
    public SecurityFilterChain filterChain(HttpSecurity http) throws Exception {
        http.authorizeHttpRequests(auth -> auth
                // 誰でもアクセス可能なページ
                .requestMatchers(
                        "/",
                        "/projects",
                        "/projects/{id}",
                        "/blog",
                        "/blog/{id}",
                        "/register",
                        "/css/**",
                        "/js/**",
                        "/images/**")
                .permitAll()
                // /admin/** はログイン必須
                .anyRequest().authenticated())
                .formLogin(form -> form
                        .loginPage("/login") // カスタムログインページ
                        .loginProcessingUrl("/login") // POST 先（Spring Security が処理）
                        .defaultSuccessUrl("/admin/projects", true)
                        .failureUrl("/login?error")
                        .permitAll())
                .logout(logout -> logout
                        .logoutUrl("/logout")
                        .logoutSuccessUrl("/?logout")
                        .invalidateHttpSession(true) // PHP の session_destroy() に相当
                        .deleteCookies("JSESSIONID")
                        .permitAll());

        return http.build();
    }
}
