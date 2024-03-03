<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Exams\ExamController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\Students\FeesContoller;
use App\Http\Controllers\Quizzes\QuizzController;
use App\Http\Controllers\Sections\SectionController;
use App\Http\Controllers\Students\PaymentController;
use App\Http\Controllers\Students\StudentController;
use App\Http\Controllers\Subjects\SubjectController;
use App\Http\Controllers\Teachers\TeacherController;
use App\Http\Controllers\questions\QuestionController;
use App\Http\Controllers\Students\GraduatedController;
use App\Http\Controllers\Students\PromotionController;
use App\Http\Controllers\Students\AttendanceController;
use App\Http\Controllers\Classrooms\ClassroomController;
use App\Http\Controllers\Students\FeesInvoicesController;
use App\Http\Controllers\Students\OnlineClasseController;
use App\Http\Controllers\Students\ProcessingFeeController;
use App\Http\Controllers\Students\ReceiptStudentsController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::group(['middleware'=>['guest']],function(){
    Route::get('/', function () {
        return view('auth.login');
    });


});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['verified'])->name('dashboard');



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth' ]
    ], function(){

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route::group([ 'Grades'], function () {
        Route::resource('Grades', GradeController::class);
    });

     //==============================Classrooms============================
  Route::group(['Classrooms'], function () {
    Route::resource('Classrooms', ClassroomController::class);
    Route::post('delete_all', [ClassroomController::class,'delete_all'])->name('delete_all');

    Route::post('Filter_Classes', [ClassroomController::class,'Filter_Classes'])->name('Filter_Classes');

});

  //==============================Sections============================

  Route::group(['Sections'], function () {

    Route::resource('Sections', SectionController::class);

    Route::get('/classes/{id}', [SectionController::class,'getclasses']);

});
  //==============================parents============================

  Route::view('add_parent','livewire.show_Form');

 //==============================Teachers============================
    Route::group(['Teachers'], function () {
        Route::resource('Teachers', TeacherController::class);
    });
      //==============================Students============================
      Route::group(['Students'], function () {
        Route::resource('Students', StudentController::class);
        Route::get('/indirect', [OnlineClasseController::class,'indirectCreate'])->name('indirect.create');
        Route::post('/indirect', [OnlineClasseController::class, 'storeIndirect'])->name('indirect.store');
        Route::resource('online_classes', OnlineClasseController::class);
        Route::resource('Graduated', GraduatedController::class);
        Route::resource('Promotion', PromotionController::class);
        Route::resource('Fees_Invoices', FeesInvoicesController::class);
        Route::resource('Fees', FeesContoller::class);
        Route::resource('receipt_students', ReceiptStudentsController::class);
        Route::resource('ProcessingFee', ProcessingFeeController::class);
        Route::resource('Payment_students', PaymentController::class);
        Route::resource('Attendance', AttendanceController::class);
        Route::get('/Get_classrooms/{id}', [StudentController::class, 'Get_classrooms']);
        Route::get('/Get_Sections/{id}', [StudentController::class, 'Get_Sections']);
        Route::post('Upload_attachment', [StudentController::class, 'Upload_attachment'])->name('Upload_attachment');
        Route::get('Download_attachment/{studentsname}/{filename}', [StudentController::class, 'Download_attachment'])->name('Download_attachment');
        Route::post('Delete_attachment', [StudentController::class, 'Delete_attachment'])->name('Delete_attachment');

    });
      //==============================Subjects============================
      Route::group(['Subjects'], function () {
        Route::resource('subjects', SubjectController::class);
    });
       //==============================Exams============================
       Route::group(['Exams'], function () {
        Route::resource('Exams', ExamController::class);
    });
      //==============================Quizzes============================
      Route::group(['Quizzes'], function () {
        Route::resource('Quizzes', QuizzController::class);
    });

    //==============================questions============================
    Route::group(['questions'], function () {
        Route::resource('questions', QuestionController::class);
    });


});




require __DIR__.'/auth.php';
