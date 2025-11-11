<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Example model for use with the CodeSnippetResource example.
 *
 * Create this migration:
 *
 * Schema::create('code_snippets', function (Blueprint $table) {
 *     $table->id();
 *     $table->string('title');
 *     $table->text('description')->nullable();
 *     $table->string('language');
 *     $table->longText('code');
 *     $table->json('tags')->nullable();
 *     $table->string('category')->nullable();
 *     $table->boolean('is_public')->default(false);
 *     $table->timestamps();
 * });
 */
class CodeSnippet extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'language',
        'code',
        'tags',
        'category',
        'is_public',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_public' => 'boolean',
    ];
}
