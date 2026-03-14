package com.example.portfolio.repository;

import com.example.portfolio.model.Project;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;
import java.util.Optional;

/**
 * projects テーブルへのアクセス。
 * PHP の add_work / details / hide_work に相当するクエリを定義。
 */
public interface ProjectRepository extends JpaRepository<Project, Long> {

    /**
     * 公開中の作品を表示順に取得（トップページのギャラリー）。
     * delete_flag = 0 のみ表示。
     */
    List<Project> findByDeleteFlagOrderBySortOrderAsc(int deleteFlag);

    /**
     * ID と delete_flag で1件取得（詳細ページ）。
     * 論理削除された作品は表示しない。
     */
    Optional<Project> findByIdAndDeleteFlag(Long id, int deleteFlag);
}
