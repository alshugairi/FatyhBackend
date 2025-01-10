<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\{Contracts\View\View, Http\RedirectResponse, Http\Request};
use Illuminate\Support\Facades\File;

class TranslationController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $languages = $this->getLanguages();
        $files = $this->getTranslationFiles();

        return view('admin.modules.settings.translations.index', compact('languages', 'files'));
    }

    /**
     * @param $lang
     * @param $file
     * @return View
     */
    public function edit($lang, $file): View
    {
        $translations = $this->getTranslations($lang, $file);

        return view('admin.modules.settings.translations.edit', compact('lang', 'file', 'translations'));
    }

    /**
     * @param Request $request
     * @param $lang
     * @param $file
     * @return RedirectResponse
     */
    public function update(Request $request, $lang, $file): RedirectResponse
    {
        $data = $request->validate([
            'translations' => 'required|array',
        ]);

        $langFile = lang_path("$lang/$file.php");
        $content = "<?php\n\nreturn " . var_export($data['translations'], true) . ";\n";

        if (! File::exists(dirname($langFile))) {
            File::makeDirectory(dirname($langFile), 0777, true, true);
        }

        File::put($langFile, $content);
        flash(__('admin.updated_successfully'), ['module' => __('admin.translations')])->success();
        return redirect()->route('admin.translations.edit', [$lang, $file]);
    }

    /**
     * Get available languages.
     *
     * @return array
     */
    private function getLanguages(): array
    {
        return array_map('basename', File::directories(lang_path()));
    }

    /**
     * Get translation files for each language.
     *
     * @return array
     */
    private function getTranslationFiles(): array
    {
        $files = [];
        foreach ($this->getLanguages() as $lang) {
            $langPath = lang_path($lang);
            $files[$lang] = array_map(function ($file) {
                return pathinfo($file, PATHINFO_FILENAME);
            }, File::files($langPath));
        }
        return $files;
    }

    /**
     * Get translations from a specific language file.
     *
     * @param string $lang
     * @param string $file
     * @return array
     */
    private function getTranslations($lang, $file): array
    {
        $path = lang_path("$lang/$file.php");
        return File::exists($path) ? include $path : [];
    }
}
