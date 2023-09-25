<?php

use App\Http\Controllers\MemberCG;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', 'AuthController@index')->name('login');
    Route::post('/login', 'AuthController@login')->name('postlogin');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'Dashboard@index')->name('Dashboard');
    Route::get('/dashboard/get-card', 'Dashboard@card_profile')->name('Dashboard.card-profile');
    Route::get('/logout', 'AuthController@logout')->name('logout');

    Route::prefix("profile")->group(function(){
        Route::get('/', 'ProfileController@profile')->name('profile');
    });
    
    // Kelola karyawan
    Route::prefix("employeemember")->group(function(){
        Route::get('/', 'MemberCG@index')->name('EmployeeMember');
        Route::get('/employeemember/cgJson', 'MemberCG@cgJson')->name('EmployeeMember.get');
        Route::get('/employeemember', 'MemberCG@getMember')->name('EmployeeMember.getJson');
        Route::post('/employeemember-post', 'MemberCG@store')->name('EmployeeMember.post');
        Route::get('/form-employeemember-edit', 'MemberCG@edit')->name('EmployeeMember.edit');
        Route::post('/employeemember-edit','MemberCG@update')->name('EmployeeMember.update');
        Route::get('/employeemember-detail', 'MemberCG@detail')->name('EmployeeMember.detail');
        Route::get('/employeemember-delete/{id}', 'MemberCG@deleteMember')->name('EmployeeMember.delete');
        Route::post('/employeemember-rotation', 'MemberCG@memberRotation')->name('EmployeeMember.rotation');
    });

    // Route::get('/member', [MemberCG::class, 'index'])->name('Member');
    // Route::get('/member', [MemberCG::class, 'index'])->name('Member');
    // Route::get('/member', [MemberCG::class, 'index'])->name('Member');
    // Route::get('/member', [MemberCG::class, 'index'])->name('Member');
    // Route::get('/member', [MemberCG::class, 'index'])->name('Member');
    // Route::get('/member', [MemberCG::class, 'index'])->name('Member');
    // Route::get('/member', [MemberCG::class, 'index'])->name('Member');
    // Route::get('/member', [MemberCG::class, 'index'])->name('Member');
    // Route::get('/member', [MemberCG::class, 'index'])->name('Member');



    Route::get('/get-divisi', 'MemberCG@getDivisi')->name('get.divisi');
    Route::get('/get-jabatan', 'MemberCG@getJabatan')->name('get.jabatan');
    Route::get('/get-level', 'MemberCG@getLevel')->name('get.level');
    Route::get('/get-department', 'MemberCG@getDepartment')->name('get.department');
    Route::get('/get-subdept', 'MemberCG@getSubDepartment')->name('get.sub.department');
    Route::get('/get-cg', 'MemberCG@getLigaCG')->name('get.cg');

    Route::get('/competencies-group', 'CompetenciesGroup@index')->name('CompetenciesGroup');
    Route::get('/achievement-competencies', 'AchievementCompetencies@index')->name('AchievementCompetencies');

    // Kurikulum
    Route::prefix("curriculum")->group(function () {
        Route::get('/', 'Curriculum@index')->name('Curriculum');
        Route::get('/cr/get-skill', 'Curriculum@getSkill')->name('get.skill');
        Route::get('/cr/get-jabatan', 'Curriculum@getJabatan')->name('get.cr.jabatan');
        Route::post('/curriculum-post', 'Curriculum@store')->name('Curriculum.post');
        Route::get('/form-edit-curriculum','Curriculum@getFormEditCurriculum')->name('getFormEditCurriculum');
        Route::post('/curriculum-edit', 'Curriculum@editCurriculum')->name('editCurriculum');
        Route::get('/curriculum-delete/{id}', 'Curriculum@delete')->name('Curriculum.delete');
    });
    Route::prefix("loghistory")->group(function () {
        Route::get('/', 'CurriculumActivityLogController@index')->name('LogHistory');
        Route::get('/json', 'CurriculumActivityLogController@json')->name('curriculumActivityLog.get');
    });

    // Taging
    Route::prefix("tagging-list")->group(function () {
        Route::get('/', 'Tagging@index')->name('TagList');
        Route::get('/tagging-json','Tagging@tagingJson')->name('taggingJson');
        Route::get('/tagging-member','Tagging@tagingJsonMember')->name('taggingJsonMember');
        Route::get('/tagging-atasan','Tagging@tagingJsonAtasan')->name('taggingJsonAtasan');
        Route::get('/form','Tagging@formTaggingList')->name('tagingForm');
        Route::post('/action','Tagging@actionTagingList')->name('actionTagingList');
        Route::get('/detail','Tagging@detail')->name('tagingDetail');
        Route::get('/export-tagging','Tagging@exportTaggingList')->middleware(['isAdmin'])->name('exportTaggingList');
        Route::get('/tagging-print','Tagging@taggingPrint')->middleware(['isAdmin'])->name('taggingPrint');
        // Route::delete('/tagging-delete/{id_taging_reason}', 'Tagging@deleteTagging');   
        Route::post('/delete','Tagging@deleteTagging')->name('tagging.destroy');
 

    });

    // Competency Directory
    Route::prefix("competencies-directory")->group(function () {
        Route::get('/', 'CompetenciesDirectory@index')->name('CompetenciesDirectory');
        Route::get('/json', 'CompetenciesDirectory@jsonDataTable')->name("jsonCompetencyDirectory");
        Route::get('/form','CompetenciesDirectory@formCompetency')->name('formCompetency');
        Route::get('/add-row','CompetenciesDirectory@addRow')->name('addRow');
        Route::post('/action','CompetenciesDirectory@storeCompetencyDirectory')->name('storeCompetencyDirectory');
        Route::get('/detail','CompetenciesDirectory@detail')->name("detailCompetencyDirectory");

        Route::get('/cek','CompetenciesDirectory@dataTableGrouping');
    });

    // White Tag
    Route::prefix("mapping-competencies")->group(function () {
        Route::get('/', 'WhiteTag@index')->name('WhiteTag');
        Route::get('/mapping-competencies-json', 'WhiteTag@whiteTagJson')->name('memberJson');
        Route::get('/mapping-competencies-all-json', 'WhiteTag@whiteTagAll')->name('whiteTagAll');
        Route::get('/mapping-competencies-member', 'WhiteTag@whiteTagRoleMember')->name('whiteTagRoleMember');
        Route::get('/mapping-competencies-all-export','WhiteTag@exportWhiteTagAll')->middleware(['isAdmin'])->name('exportWhiteTagAll');
        Route::get('/form','WhiteTag@formWhiteTag')->name("formWhiteTag");
        Route::post('/action','WhiteTag@actionWhiteTag')->name("actionWhiteTag");
        Route::get('/detail', 'WhiteTag@detailWhiteTag')->name('detailWhiteTag');

        Route::get('/chart-skill-category','WhiteTag@chartSkillCategory')->name("chartSkillCategory");
        Route::get('/chart-comp-grour','WhiteTag@chartCompGroup')->name("chartCompGroup");
    });

    //CEME
    Route::get('/ceme', 'Ceme@index')->name('ceme');
    Route::get('/ceme?q=all', 'Ceme@index')->name('ceme.all');
    Route::get('/ceme/json','Ceme@cgJson')->name('ceme.json');
    Route::get('/ceme/json/all','Ceme@cgJsonAll')->name('ceme.json.all');
    Route::post('/ceme-post', 'Ceme@actionCeme')->name('actionCeme');
    Route::post('ceme/add-job-title','Ceme@addJobTitle')->name('ceme.addJobTitle');
    Route::post('ceme/get-job-title','Ceme@getJobTitle')->name('ceme.getJobTitle');
    Route::post('ceme/delete-job-title','Ceme@deleteJobTitle')->name('ceme.deleteJobTitle');
    Route::post('ceme/chartCeme','Ceme@chartCeme')->name('ceme.chartCeme');
    Route::post('ceme/chartMe','Ceme@chartMe')->name('ceme.chartMe');


    Route::prefix("grade")->group(function () {
        Route::get('/', 'Grade@index')->name('Grade');
        Route::post('/grade-post', 'Grade@store')->name('Grade.post');
        Route::get('/form-edit-Grade', 'Grade@getFormEditGrade')->name('getFormEditGrade');
        Route::post('/grade-edit', 'Grade@editGrade')->name('editGrade');
        Route::get('/grade-delete/{id}', 'Grade@delete')->name('Grade.delete');
    });


    Route::prefix("skill-categoty")->group(function () {
        Route::get('/', 'SkillCategory@index')->name('SkillCategory');
        Route::get('/get','SkillCategory@get')->name('SkillCategory.get');
        Route::post('/create','SkillCategory@store')->name('SkillCategory.store');
        Route::post('/delete', 'SkillCategory@delete')->name('SkillCategory.delete');
    });

    Route::prefix("cg-master")->group(function () {
        Route::get('/', 'CGMaster@index')->name('CG');
        Route::post('/create', 'CGMaster@store')->name('CG.post');
        Route::post('/delete','CGMaster@destroy')->name('CG.destroy');
        // Route::get('/form-edit', 'CGMaster@FormEditCGMaster')->name('getFormEditCGMaster');
        // Route::post('/edit', 'CGMaster@editCGMaster')->name('editCGMaster');
        // Route::get('/delete/{id}', 'CGMaster@delete')->name('CGMaster.delete');
    });

    // department
    Route::prefix("department")->group(function () {
        Route::get('/', 'DepartmentController@index')->name('department.index');
        Route::post('/create', 'DepartmentController@store')->name('department.store');
        Route::post('/delete','DepartmentController@destroy')->name('department.destroy');
    });

    // divisi
    Route::prefix("divisi")->group(function () {
        Route::get('/', 'DivisiController@index')->name('divisi.index');
        Route::post('/create', 'DivisiController@store')->name('divisi.store');
        Route::post('/delete','DivisiController@destroy')->name('divisi.destroy');
    });

     // jabatan/jobtitle
    Route::prefix("jabatan")->group(function () {
        Route::get('/', 'JabatanController@index')->name('jabatan.index');
        Route::get('/get','JabatanController@get')->name('jabatan.get');
        Route::post('/create', 'JabatanController@store')->name('jabatan.store');
        Route::post('/delete','JabatanController@destroy')->name('jabatan.destroy');
    });

     // grade
    Route::prefix("grade")->group(function () {
        Route::get('/', 'Grade@index')->name('grade.index');
        Route::post('/create', 'Grade@store')->name('grade.store');
        Route::post('/delete','Grade@destroy')->name('grade.destroy');
    });

    // sub department
    Route::prefix("sub-department")->group(function () {
        Route::get('/', 'SubDepartmentController@index')->name('sub-department.index');
        Route::post('/create', 'SubDepartmentController@store')->name('sub-department.store');
        Route::post('/delete','SubDepartmentController@destroy')->name('sub-department.destroy');
    });

     // level
    Route::prefix("level")->group(function () {
        Route::get('/', 'LevelController@index')->name('level.index');
        Route::post('/create', 'LevelController@store')->name('level.store');
        Route::post('/delete','LevelController@destroy')->name('level.destroy');
    });

    // sub department
    Route::prefix("competencie-groups")->group(function () {
        Route::get('/', 'CompetencieGroupController@index')->name('competencie-groups.index');
        Route::post('/create', 'CompetencieGroupController@store')->name('competencie-groups.store');
        Route::post('/delete','CompetencieGroupController@destroy')->name('competencie-groups.destroy');
        Route::post('/get-skill','CompetencieGroupController@getBySkillCategory')->name('competencie-groups.getBySkillCategory');
    });

    // targets
    Route::prefix("target")->group(function () {
        Route::get('/', 'TargetController@index')->name('target.index');
        Route::post('/create', 'TargetController@store')->name('target.store');
        Route::post('/delete','TargetController@destroy')->name('target.destroy');
    });

    //Superman
    Route::prefix("superman")->group(function () {
        Route::get('/member-superman', 'SupermanController@indexMember')->name('member.superman.index');
        Route::get('/member-superman/superman-json', 'SupermanController@supermanMemberJson')->name('get.member.superman');
        Route::post('/member-superman-post', 'SupermanController@supermanMemberStore')->name('post.member.superman');
        Route::get('/member-superman-detail', 'SupermanController@detail')->name('member-superman.detail');
        Route::get('/member-superman-delete/{id}', 'SupermanController@supermanMemberDelete')->name('delete.member.superman');

        Route::get('/', 'SupermanController@index')->name('superman.index');
        Route::get('/get', 'SupermanController@getSuperman')->name('superman.get');
        Route::post('/create', 'SupermanController@store')->name('superman.store');
        Route::get('/get-form','SupermanController@getFormEdit')->name('superman.get.form');
        Route::post('/edit', 'SupermanController@edit')->name('superman.update');
        Route::get('/delete/{id}','SupermanController@destroy')->name('superman.destroy');

        Route::get('/kelola/superman', 'SupermanController@indexKelola')->name('kelola.superman.index');
        Route::get('/kelola/json', 'SupermanController@supermanJson')->name('superman.json');
        Route::get('/kelola/form','SupermanController@formSuperman')->name("form.superman");
        Route::post('/kelola/action','SupermanController@actionSuperman')->name("action.superman");
        Route::get('/kelola/detail', 'SupermanController@detailMapcomSuperman')->name('detail.kelola.superman');
    });

    // Champion 4.0
    Route::prefix("champion")->group(function () {
        Route::get('/member-champion', 'ChampionController@indexMember')->name('member.champion.index');
        Route::get('/member-champion/superman-json', 'ChampionController@championJson')->name('get.member.champion');
        Route::post('/member-champion-post', 'ChampionController@championMemberStore')->name('post.member.champion');
        Route::get('/member-champion-detail', 'ChampionController@detail')->name('member-champion.detail');
        Route::get('/member-champion-delete/{id}', 'ChampionController@championMemberDelete')->name('delete.member.champion');

        Route::get('/', 'ChampionController@indexMaster')->name('champion.index');
        Route::get('/get', 'ChampionController@getChampion')->name('champion.get');
        Route::post('/create', 'ChampionController@store')->name('champion.store');
        Route::get('/get-form','ChampionController@getFormEdit')->name('champion.get.form');
        Route::post('/edit', 'ChampionController@edit')->name('champion.update');
        Route::post('/delete','ChampionController@destroy')->name('champion.destroy');

        Route::get('/kelola/champion', 'ChampionController@index')->name('kelola.champion.index');
        Route::get('/kelola/json', 'ChampionController@getJson')->name('champion.json');
        Route::get('/kelola/form','ChampionController@formChampion')->name('form.champion');
        Route::post('/kelola/action','ChampionController@actionChampion')->name("action.champion");
        Route::get('/kelola/detail', 'ChampionController@detailMapcomChampion')->name('detail.kelola.champion');

    });

    // Management System
    Route::prefix("management-system")->group(function () {
        Route::get('/master', 'ManagementSystemController@indexMaster')->name('master.system.index');
        Route::post('/master-create', 'ManagementSystemController@storeMaster')->name('master.system.store');
        Route::post('/master-delete','ManagementSystemController@destroyMaster')->name('master.system.destroy');

        Route::get('/', 'ManagementSystemController@index')->name('system.index');
        Route::post('/create', 'ManagementSystemController@store')->name('system.store');
        Route::post('/delete','ManagementSystemController@destroy')->name('system.destroy');

        Route::post('/get-target','ManagementSystemController@getTarget')->name('system.get.target');
    });
    Route::prefix("master-management-system")->group(function(){
        Route::get('/', 'ManagementSystemController@indexMaster')->name('master.system.index');
        Route::get('/get', 'ManagementSystemController@getSystem')->name('master.system.get');
    });

    // Rotation
    Route::prefix("rotation")->group(function(){
        Route::get('/', 'RotationController@index')->name('rotation.index');
        Route::get('/comp-history', 'RotationController@indexHistory')->name('comp.history.index');
        Route::get('/get', 'RotationController@getRotation')->name('rotation.get');
    });
});
