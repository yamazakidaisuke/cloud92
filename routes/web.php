<?php

use App\Book;
use Illuminate\Http\Request;

/**
* 本のダッシュボード表示(books.blade.php)
*/
Route::get('/', function () {
    $books = Book::orderBy('created_at', 'asc')->get();
    return view('books', [
        'books' => $books
    ]);
    //return view('books',compact('books')); //も同じ意味
});


/**
* 新「本」を追加 
*/

Route::post('/books', function (Request $request) {

    //バリデーション
    $validator = Validator::make($request->all(), [
        'item_name' => 'required|max:255',
    ]);

    //バリデーション:エラー 
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    //以下に登録処理を記述（Eloquentモデル）
    
    // Eloquentモデル
    $books = new Book;
    $books->item_name = $request->item_name;
    $books->item_number = '1';
    $books->item_amount = '1000';
    $books->published = '2017-03-07 00:00:00';
    $books->save(); 
    return redirect('/');

});


/**
* 本を削除 
*/

Route::delete('/book/{book}', function (Book $book) {
    $book->delete();       //追加
    return redirect('/');  //追加
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
