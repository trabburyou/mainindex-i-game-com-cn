<?php

/**
 * Site Metadata Provider
 * 
 * Provides a structured representation of site information,
 * including a method to generate a concise descriptive text.
 */

class SiteMeta
{
    /**
     * @var array<string, mixed>
     */
    private array $meta;

    /**
     * @param array<string, mixed> $meta
     */
    public function __construct(array $meta = [])
    {
        $this->meta = array_merge($this->getDefaultMeta(), $meta);
    }

    /**
     * @return array<string, mixed>
     */
    private function getDefaultMeta(): array
    {
        return [
            'site_name' => 'MainIndex Game',
            'site_url' => 'https://mainindex-i-game.com.cn',
            'language' => 'zh-CN',
            'keywords' => ['爱游戏', '游戏资讯', '游戏评测'],
            'description' => '专注于最新游戏动态和深度评测的综合性游戏平台',
            'author' => 'GameIndex Team',
            'version' => '1.0.0',
            'last_updated' => date('Y-m-d'),
            'theme_color' => '#2c3e50',
        ];
    }

    /**
     * Get the full meta array.
     *
     * @return array<string, mixed>
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * Get a specific meta value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->meta[$key] ?? $default;
    }

    /**
     * Generate a short descriptive text from the meta data.
     *
     * @return string
     */
    public function generateDescription(): string
    {
        $name = htmlspecialchars($this->get('site_name', ''), ENT_QUOTES, 'UTF-8');
        $desc = htmlspecialchars($this->get('description', ''), ENT_QUOTES, 'UTF-8');
        $keywords = $this->get('keywords', []);
        $keywordStr = '';

        if (is_array($keywords) && !empty($keywords)) {
            $safeKeywords = array_map(function ($kw) {
                return htmlspecialchars((string)$kw, ENT_QUOTES, 'UTF-8');
            }, $keywords);
            $keywordStr = implode('、', $safeKeywords);
        }

        $parts = array_filter([
            $name,
            $desc,
            $keywordStr ? "关注关键词：" . $keywordStr : null,
        ]);

        return implode(' - ', $parts);
    }

    /**
     * Return a simple string summary line.
     *
     * @return string
     */
    public function toSummaryString(): string
    {
        $name = $this->get('site_name', '');
        $url = $this->get('site_url', '');
        $keywords = $this->get('keywords', []);
        $firstKeyword = '';

        if (is_array($keywords) && count($keywords) > 0) {
            $firstKeyword = (string)$keywords[0];
        }

        $result = sprintf(
            '%s (%s) | %s',
            htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($url, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($firstKeyword, ENT_QUOTES, 'UTF-8')
        );

        return $result;
    }
}

// --- Example usage ---

// Create an instance with custom or default data
$siteMeta = new SiteMeta();

// Override any field if needed
$customMeta = new SiteMeta([
    'site_name' => '爱游戏 - 官方站点',
    'description' => '提供最新的游戏资讯和热门游戏评测',
    'keywords' => ['爱游戏', '游戏新闻', '游戏推荐'],
    'last_updated' => '2025-03-01',
]);

// Generate short description
echo $customMeta->generateDescription() . "\n";

// Summary line
echo $customMeta->toSummaryString() . "\n";