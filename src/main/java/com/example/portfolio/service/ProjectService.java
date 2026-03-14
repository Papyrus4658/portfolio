package com.example.portfolio.service;

import com.example.portfolio.model.Project;
import com.example.portfolio.repository.ProjectRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;
import java.util.NoSuchElementException;

/**
 * 作品ギャラリーのビジネスロジック。
 * PHP の add_work / details / hide_work の処理に相当。
 */
@Service
@RequiredArgsConstructor
@Transactional(readOnly = true)
public class ProjectService {

    private final ProjectRepository projectRepository;

    /** トップページ・ギャラリー用：公開中の作品一覧 */
    public List<Project> findPublished() {
        return projectRepository.findByDeleteFlagOrderBySortOrderAsc(0);
    }

    /** 詳細ページ用：1件取得（非公開は 404） */
    public Project findPublishedById(Long id) {
        return projectRepository.findByIdAndDeleteFlag(id, 0)
                .orElseThrow(() -> new NoSuchElementException("作品が見つかりません: " + id));
    }

    /** 管理画面用：全件取得（非表示含む） */
    public List<Project> findAll() {
        return projectRepository.findAll();
    }

    /** 作品の新規登録（PHP の add_work に相当） */
    @Transactional
    public Project save(Project project) {
        return projectRepository.save(project);
    }

    /**
     * 論理削除（PHP の hide_work に相当）。
     * delete_flag を 1 にするだけで、レコードは残す。
     */
    @Transactional
    public void hide(Long id) {
        Project project = projectRepository.findById(id)
                .orElseThrow(() -> new NoSuchElementException("作品が見つかりません: " + id));
        project.setDeleteFlag(1);
        projectRepository.save(project);
    }

    /** 非表示の作品を再公開 */
    @Transactional
    public void restore(Long id) {
        Project project = projectRepository.findById(id)
                .orElseThrow(() -> new NoSuchElementException("作品が見つかりません: " + id));
        project.setDeleteFlag(0);
        projectRepository.save(project);
    }
}
