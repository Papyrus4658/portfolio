package com.example.portfolio.controller;

import com.example.portfolio.service.ProjectService;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;

/**
 * トップページのコントローラ。
 * PHP の index.php に相当。
 */
@Controller
@RequiredArgsConstructor
public class HomeController {
    private final ProjectService projectService;

    /**
     * GET /
     * 公開中の作品一覧をトップページに表示する。
     */
    @GetMapping("/")
    public String index(Model model) {
        model.addAttribute("projects", projectService.findPublished());
        return "index"; // templates/index.html
    }

    /** GET /login — ログインページ（Spring Security がフォーム POST を処理） */
    @GetMapping("/login")
    public String login() {
        return "login"; // templates/login.html
    }
}
