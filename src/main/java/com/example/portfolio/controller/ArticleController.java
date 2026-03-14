package com.example.portfolio.controller;

import com.example.portfolio.model.Article;
import com.example.portfolio.service.ArticleService;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

/**
 * ブログ記事コントローラ。
 *
 * 公開側:
 * GET /blog → 記事一覧
 * GET /blog/{id} → 記事詳細
 *
 * 管理側（要ログイン）:
 * GET /admin/articles → 管理一覧
 * GET /admin/articles/new → 新規作成フォーム
 * POST /admin/articles → 作成処理
 * GET /admin/articles/{id}/edit → 編集フォーム
 * POST /admin/articles/{id} → 更新処理
 * POST /admin/articles/{id}/delete → 論理削除
 */
@Controller
@RequiredArgsConstructor
public class ArticleController {
    private final ArticleService articleService;

    /* ------------------------------------------------------------------ */
    /* 公開側 */
    /* ------------------------------------------------------------------ */

    @GetMapping("/blog")
    public String list(Model model) {
        model.addAttribute("articles", articleService.findPublished());
        return "blog/list";
    }

    @GetMapping("/blog/{id}")
    public String detail(@PathVariable Long id, Model model) {
        model.addAttribute("article", articleService.findPublishedById(id));
        return "blog/detail";
    }

    /* ------------------------------------------------------------------ */
    /* 管理側 */
    /* ------------------------------------------------------------------ */

    @GetMapping("/admin/articles")
    public String adminList(Model model) {
        model.addAttribute("articles", articleService.findAll());
        return "admin/articles/list";
    }

    @GetMapping("/admin/articles/new")
    public String newForm(Model model) {
        model.addAttribute("article", new Article());
        return "admin/articles/form";
    }

    @PostMapping("/admin/articles")
    public String create(@Valid @ModelAttribute Article article,
            BindingResult result, RedirectAttributes ra) {
        if (result.hasErrors())
            return "admin/articles/form";
        articleService.save(article);
        ra.addFlashAttribute("successMessage", "記事を保存しました。");
        return "redirect:/admin/articles";
    }

    @GetMapping("/admin/articles/{id}/edit")
    public String editForm(@PathVariable Long id, Model model) {
        model.addAttribute("article", articleService.findById(id));
        return "admin/articles/form";
    }

    @PostMapping("/admin/articles/{id}")
    public String update(@PathVariable Long id,
            @Valid @ModelAttribute Article article,
            BindingResult result, RedirectAttributes ra) {
        if (result.hasErrors())
            return "admin/articles/form";
        article.setId(id);
        articleService.save(article);
        ra.addFlashAttribute("successMessage", "記事を更新しました。");
        return "redirect:/admin/articles";
    }

    @PostMapping("/admin/articles/{id}/delete")
    public String delete(@PathVariable Long id, RedirectAttributes ra) {
        articleService.delete(id);
        ra.addFlashAttribute("successMessage", "記事を削除しました。");
        return "redirect:/admin/articles";
    }
}
