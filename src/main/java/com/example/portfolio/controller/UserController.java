package com.example.portfolio.controller;

import com.example.portfolio.service.UserService;
import jakarta.validation.constraints.Email;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.Size;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

/**
 * ユーザー管理コントローラ。
 * PHP の register_account / quit / recover_account / edit_heading に相当。
 */
@Controller
@RequiredArgsConstructor
public class UserController {
    private final UserService userService;

    /* ------------------------------------------------------------------ */
    /* 新規登録（register_account に相当） */
    /* ------------------------------------------------------------------ */

    @GetMapping("/register")
    public String registerForm() {
        return "register";
    }

    @PostMapping("/register")
    public String register(
            @RequestParam @NotBlank @Size(max = 50) String username,
            @RequestParam @NotBlank @Email String email,
            @RequestParam @NotBlank @Size(min = 8) String password,
            RedirectAttributes ra) {
        try {
            userService.register(username, email, password);
            ra.addFlashAttribute("successMessage", "登録が完了しました。ログインしてください。");
            return "redirect:/login";
        } catch (IllegalArgumentException e) {
            ra.addFlashAttribute("errorMessage", e.getMessage());
            return "redirect:/register";
        }
    }

    /* ------------------------------------------------------------------ */
    /* プロフィール編集（edit_heading に相当） */
    /* ------------------------------------------------------------------ */

    @GetMapping("/admin/profile")
    public String profileForm(@AuthenticationPrincipal UserDetails userDetails,
            Model model) {
        model.addAttribute("email", userDetails.getUsername());
        return "admin/profile";
    }

    @PostMapping("/admin/profile")
    public String updateProfile(
            @AuthenticationPrincipal UserDetails userDetails,
            @RequestParam @NotBlank @Size(max = 50) String username,
            RedirectAttributes ra) {
        try {
            userService.updateUsernameByEmail(userDetails.getUsername(), username);
            ra.addFlashAttribute("successMessage", "表示名を更新しました。");
        } catch (Exception e) {
            ra.addFlashAttribute("errorMessage", "更新に失敗しました。");
        }

        return "redirect:/admin/profile";
    }

    /* ------------------------------------------------------------------ */
    /* 退会（quit に相当） */
    /* ------------------------------------------------------------------ */

    @PostMapping("/admin/withdraw")
    public String withdraw(@AuthenticationPrincipal UserDetails userDetails,
            RedirectAttributes ra) {
        userService.withdrawByEmail(userDetails.getUsername());
        ra.addFlashAttribute("successMessage", "退会処理が完了しました。");

        return "redirect:/logout";
    }

    /* ------------------------------------------------------------------ */
    /* アカウント復元（recover_account に相当） */
    /* ------------------------------------------------------------------ */

    @GetMapping("/recover")
    public String recoverForm() {
        return "recover";
    }

    @PostMapping("/recover")
    public String recover(@RequestParam @NotBlank @Email String email,
            RedirectAttributes ra) {
        try {
            userService.recover(email);
            ra.addFlashAttribute("successMessage", "アカウントを復元しました。ログインしてください。");
        } catch (Exception e) {
            ra.addFlashAttribute("errorMessage", "該当するアカウントが見つかりません。");
        }

        return "redirect:/login";
    }
}
