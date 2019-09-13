# Stupid Framework

Simple framework with a routing system (?). No Composer (Thanks STIKOM).

## Table Of Content

- [Requirement](#requirement)
- [Development](#development)
- [Production](#production)
- [Folder/File Structure](#folder-file-structure)
- [How To Use](#how-to-use)
  - [Configuration](#configuration)
  - [Routing](#routing)
    - [Basic Handling](#basic-handling)
    - [Controller](#controller)
  - [Middleware](#middleware)
    - [Route Level Middleware](#route-level-middleware)
    - [Router Level Middleware](#router-level-middleware)
  - [Request](#request)
  - [Response](#response)
  - [View](#view)
    - [Basic](#basic)
    - [Component](#component)
  - [Helper](#helper)
  - [Other](#other)

## Requirement

1. PHP == 5.3 (Thanks again STIKOM)
2. Node JS (latest (but LTS) better) for compiling assets.

## Development

1. Atur `config.php`.
2. Jalankan `npm run dev` untuk meng-compile aset dan menjalankan Webpack Dev Server.
3. Jalankan `localhost/path/to/public` di browser anda. Atau lebih baik atur web server agar langsung menarget folder `public`, jadi nanti tinggal akses `localhost` saja.

## Production

1. Jalankan `npm run build` untuk meng-compile aset.
2. Copy semua file dan folder kecuali `node_modules` dan file konfigurasi JS (Eslint, Prettier, dll).
3. Pastikan web server mengarah ke folder `public`.

## Folder/File Structure

| Folder/File          | Deskripsi                                                                                             |
|----------------------|-------------------------------------------------------------------------------------------------------|
| /                    | ...                                                                                                   |
| /app                 | Source aplikasi.                                                                                      |
| /app/controller      | Folder untuk meletakan controller/route handler dari aplikasi.                                        |
| /app/middleware      | Folder untuk meletakan middleware dari aplikasi anda.                                                 |
| /core                | Source inti framework.                                                                                |
| /core/interface      | Berisikan Interface khusus untuk core framework.                                                      |
| /core/Autoloader.php | Class yang bertugas sebagai autoloader class.                                                         |
| /core/Error.php      | Class yang bertugas untuk menangani error dari aplikasi.                                              |
| /core/Request.php    | Class yang bertugas untuk memanipulasi data request.                                                  |
| /core/Response.php   | Class yang bertugas untuk memanipulasi data response.                                                 |
| /core/Router.php     | Class yang bertugas untuk menangani routing.                                                          |
| /public              | Folder yang menyimpan file yang bisa diakses secara publik seperti JS, CSS, .htaccess, dan index.php. |
| /util                | Folder yang menyimpan file-file utilitas/helper.                                                      |
| /util/index.php      | File yang bertugas untuk meregistrasi semua helper.                                                   |
| /view                | Folder untuk meletakan file view dari aplikasi.                                                       |
| /app.php             | File yang berisikan definisi dari router aplikasi.                                                    |
| /bootstrap.php       | File yang bertugas untuk memuat semua file dan class supaya aplikasi dapat berjalan.                  |
| /config.php          | File konfigurasi untuk aplikasi.                                                                      |

## How To Use

### Configuration

Anda bisa mengatur konfigurasi aplikasi di dalam file `/config.php`. Untuk memanggil nilai dari konfigurasi bisa menggunakan helper `config()`. Contoh:

```php
config('debug'); // Akan mengambil nilai dari debug
config('db.name'); // Akan mengambil nilai dari db => name
```

### Routing

Untuk menyusun definisi routing dari aplikasi bisa dilakukan di dalam file `/app.php`. Contoh sederhana:

:warning: Sistem routing belum mendukung parameter di dalam URL seperti: `/path/{id}`.

```php
// Panggil class Router dan Request
use Core\Router;
use Core\Request;

// Buat objek router. Objek router perlu objek request.
$router = new Router(new Request);

// Definisikan routing aplikasi
$router->get('/book', null, /** Put handler here **/);
$router->post('/book', null, /** Put handler here **/);

// Panggil run() supaya router bisa mengeksekusi
// route yang ditarget oleh request.
$router->run();
```

Terdapat 3 argumen di dalam definisi sebuah route yakni:

- Request URI
- Array dari middleware (default: `null`)
- Handler

#### Basic Handling

Handler dapat dibuat dengan menggunakan callback. Callback tersebut memiliki 1 parameter yakni `$request` yang merupakan objek dari class `Core\Request`. Contoh:

```php
$router->get('/book', null, function ($request) {
  // Do something
  $data = array(
    'message' => 'Hi'
  );

  return response()->json($data);
});
```

#### Controller

Handler juga bisa dibuat dengan menggunakan controller. Contoh:

1. Buat class controller di dalam folder `/app/controller`, misal: `BookController.php`.

    ```php
    namespace App\Controller;

    use Core\Request;

    class BookController {
      public function index(Request $request) {
        // Do something
      }

      public function store(Request $request) {
        // Do something
      }
    }
    ```

2. Pasang method controller di dalam route dengan format `'<NamaClassController>@<Nama Method>'`.

    ```php
    // /app.php
    $router->get('/book', null, 'BookController@index');
    ```

### Middleware

Middleware berfungsi sebagai penjaga yang akan memproses request sebelum masuk ke dalam route handler. Di dalam middleware anda bisa memanipulasi objek `Request` seperti menambah payload. Terdapat 2 jenis middleware yang bisa diimplementasikan yakni Route level dan Router level.

#### Route Level Middleware

Middleware didefinisikan di masing-masing route. Contoh:

1. Buat class middleware di dalam folder `/app/middleware`. Pastikan class tersebut mengimplementasikan Interface `Core\I\Middleware`.

    ```php
    namespace App\Middleware;

    use Core\Request;
    use Core\I\Middleware;

    class CheckSomething implements Middleware {
      public function handle(Request $request, $next) {
        // Do Something

        return $next();
      }
    }
    ```

    Untuk melanjutkan proses ke route handler atau middleware selanjutnya pastikan selalu me-return `$next()`. Jika tidak maka request akan berhenti.

2. Pasang nama class middleware di dalam route dalam bentuk string di dalam array.

    ```php
    $router->get('/book', array('CheckSomething'), /** Handler **/);

    // Beberapa middleware
    $router->post('/book', array('Auth', 'CheckSomething'), /** Handler **/);
    ```

    Middleware akan diproses dari yang paling kiri.

#### Router Level Middleware

Middleware didefinisikan di dalam class `Router` sehingga middleware ini akan diproses paling awal dan bersifat global. Konsep nya sama seperti Route Level Middleware. Namun yang membedakan adalah:

- Class nya mengimplementasikan Interface `Core\I\RouterMiddleware`.
- Parameter pertama di method `handle()` adalah oleh objek dari `Core\Router`.
  ```php
  public function handle(Router $router, $next) {
    // Do Something
  }
  ```

Cara implementasi:

```php
// /app.php
$router->apply(new CheckSomething());

// Definisi route
```

### Request

Semua data `$_SERVER` bisa diakses melalui objek `Core\Request` yang diinisialisasi dari class `'Core\Router`. Contoh:

```php
echo $_SERVER['REQUEST_URI'];

// Menggunakan objek Core\Request
// Semua key diubah menjadi camelCase
echo $request->requestUri;
```

Selain mengakses data `$_SERVER` anda juga bisa mengakses payload $_POST dan $_GET serta menambah payload lain ke objek `$request`.

:warning: Hanya `form data` yang didukung oleh `$request->getBody()`.

```php
// Akses payload $_POST
$post = $request->getBody();

// Akses payload $_GET
$get = $request->getParams();
// ?name=Jeff&age=21
echo $get['name']; // Jeff

// Menambah custom payload
$request->addPayload('user', 'Jeff');

// Mengakses custom payload
// Kosongkan argumen jika ingin mengambil semua payload
echo $request->getPayload('user') // Jeff
```

### Response

Terdapat beberapa jenis response yang bisa diberikan kepada client dengan cara mengakses objek dari `Core\Response` yakni:

:information_source: Supaya lebih mudah gunakan helper `response()`.

1. JSON

    ```php
    return response()->json($array);
    ```

2. View

    ```php
    return response()->view('path.to.file');
    ```

3. Text

    ```php
    return response()->text('Lorem ipsum...');
    ```

4. Status

    ```php
    return response()->status(403);
    ```
  
5. Redirect

    ```php
    return response()->redirect('/other/route');
    ```

    Kode status dari response JSON, view, dan text bisa dimanipulasi dengan cara:

    ```php
    // Contoh untuk JSON
    return response()->json($data)->status($code);
    ```

### View

View merupakan tampilan HTML yang akan diberikan kepada client. Semua file view diletakan di folder `/view` dengan menggunakan ekstensi `.php`. Untuk memanggil view pastikan route handler melakukan hal seperti berikut:

```php
return response()->view('path.to.file');
```

String `path.to.file` akan dirubah menjadi `<path_to_view>/path/to/file.php` oleh framework.

Untuk mengoper data ke dalam view anda bisa melakukan hal seperti berikut:

```php
$payload = array(
  'title' => 'Stupid MVC',
  'content' => 'Lorem ipsum....'
);

return response()->view('path.to.file', $payload);
```

Kemudian untuk mengaksesnya anda bisa gunakan variabel `$data`:

```html
<h1><?= $data['title'] ?></h1>
<p><?= $data['content'] ?></p>
```

#### Component

Anda juga bisa memperlakukan file view sebagai komponen. Gunakan helper `part()` untuk memanggil komponen.

```html
<!-- Card Component (/view/component/card) -->
<div>
  <h4>Epic Moment</h4>
  <p>Lorem ipsum...</p>
</div>
```

```html
<!-- Base view -->
<div>
  <?php part('component.card') ?>
  <?php part('component.card') ?>
  <?php part('component.card') ?>
<div>
```

Anda juga bisa mengoper data ke dalam komponen. Akses data tersebut dengan menggunakan variabel `$data`.

```html
<!-- Card Component (/view/component/card) -->
<div>
  <h4><?php echo $data['title'] ?></h4>
  <p><?php echo $data['desc'] ?></p>
</div>
```

```html
<!-- Base view -->
<?php
  $article = array(
    'title' => 'Epic Moment',
    'desc' => 'Lorem ipsum...',
  );
?>

<div>
  <?php part('component.card', $article) ?>
<div>
```

### Helper

Secara default semua fungsi helper bisa diakses secara global. Untuk helper apa saja yang disediakan bisa mengecek di dalam folder `/util`. Anda juga bisa menambahkan custom helper asalkan fungsi tersebut berada di atau di require ke dalam file `/util/index.php`.

### Other

Jika ada merubah struktur folder atau menambah folder baru yang berisikan file-file berupa class, harap mengatur autolader di dalam file `/bootstrap.php`. Autoloading class harus dilakukan secara manual.
