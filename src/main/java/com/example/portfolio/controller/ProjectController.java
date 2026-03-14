package com.example.portfolio.controller;

import com.example.portfolio.model.Project;
import com.example.portfolio.service.ProjectService;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

/**
 * 作品ギャラリーのコントローラ。
 *
 * 公開側:
 * GET /projects → 一覧（index.php のギャラリー部分に相当）
 * GET /projects/{id} → 詳細（details/ に相当）
 *
 * 管理側（要ログイン）:
 * GET /admin/projects → 管理一覧
 * GET /admin/projects/new → 登録フォーム（add_work/ に相当）
 * POST /admin/projects → 登録処理
 * GET /admin/projects/{id}/edit → 編集フォーム
 * POST /admin/projects/{id} → 更新処理
 * POST /admin/projects/{id}/hide → 非表示（hide_work/ に相当）
 * POST /admin/projects/{id}/restore → 再公開
 */
@Controller
@RequiredArgsConstructor
public class ProjectController {
    private final ProjectService projectService;

    /* ------------------------------------------------------------------ */
    /* 公開側 */
    /* ------------------------------------------------------------------ */

    @GetMapping("/projects")
    public String list(Model model) {
        model.addAttribute("projects", projectService.findPublished());
        return "projects/list";
    }

    @GetMapping("/projects/{id}")
    public String detail(@PathVariable Long id, Model model) {
        model.addAttribute("project", projectService.findPublishedById(id));
        return "projects/detail";
    }

    /* ------------------------------------------------------------------ */
    /* 管理側 */
    /* ------------------------------------------------------------------ */

    @GetMapping("/admin/projects")
    public String adminList(Model model) {
        model.addAttribute("projects", projectService.findAll());
        return "admin/projects/list";
    }

    @GetMapping("/admin/projects/new")
    public String newForm(Model model) {
        model.addAttribute("project", new Project());
        return "admin/projects/form";
    }

    @PostMapping("/admin/projects")
    public String create(@Valid @ModelAttribute Project project,
            BindingResult result, RedirectAttributes ra) {
        if (result.hasErrors()) {
            return "admin/projects/form";
        }

        projectService.save(project);
        ra.addFlashAttribute("successMessage", "作品を登録しました。");

        return "redirect:/admin/projects";
    }

    @GetMapping("/admin/projects/{id}/edit")
    public String editForm(@PathVariable Long id, Model model) {
        model.addAttribute("project", projectService.findPublishedById(id));
        return "admin/projects/form";
    }

    @PostMapping("/admin/projects/{id}")
    public String update(@PathVariable Long id,
            @Valid @ModelAttribute Project project,
            BindingResult result,
            RedirectAttributes ra) {
        if (result.hasErrors()) {
            return "admin/projects/form";
        }

        project.setId(id);
        projectService.save(project);
        ra.addFlashAttribute("successMessage", "作品を更新しました。");

        return "redirect:/admin/projects";
    }

    /** 非表示（PHP の hide_work に相当） */
    @PostMapping("/admin/projects/{id}/hide")
    public String hide(@PathVariable Long id, RedirectAttributes ra) {
        projectService.hide(id);
        ra.addFlashAttribute("successMessage", "作品を非表示にしました。");

        return "redirect:/admin/projects";
    }

    /** 再公開 */
    @PostMapping("/admin/projects/{id}/restore")
    public String restore(@PathVariable Long id, RedirectAttributes ra) {
        projectService.restore(id);
        ra.addFlashAttribute("successMessage", "作品を再公開しました。");

        return "redirect:/admin/projects";
    }
}
