<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "expenses";

    protected $fillable = [
        'is_monthly_expense', 'amount', 'ref_no', 'exp_date', 'exp_cat_id', 'note'
    ];

    public function ExpenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'exp_cat_id');
    }

    public function scopeActive($query)
    {
        return $query->where('business_id', Auth::user()->business_id)->orderBy('created_at', 'desc');
    }

    public function media()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
