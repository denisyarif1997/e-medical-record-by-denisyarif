<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Asuransi;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Poliklinik;
use App\Models\Spesialis;
use App\Models\Obat;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $userCount = User::count();
        view()->share('userCount',$userCount);
        
        $RoleCount = Role::count();
        view()->share('RoleCount',$RoleCount);
        
        $PermissionCount = Permission::count();
        view()->share('PermissionCount',$PermissionCount);
        
        $CategoryCount = Category::count();
        view()->share('CategoryCount',$CategoryCount);
        
        $SubCategoryCount = SubCategory::count();
        view()->share('SubCategoryCount',$SubCategoryCount);
        
        $CollectionCount = Collection::count();
        view()->share('CollectionCount',$CollectionCount);
        
        $ProductCount = Product::count();
        view()->share('ProductCount',$ProductCount);

        $AsuransiCount = Asuransi::count();
        view()->share('AsuransiCount',$AsuransiCount);

        $PasienCount = Pasien::count();
        view()->share('PasienCount',$PasienCount);

        $SpesialisCount = Spesialis::count();
        view()->share('SpesialisCount',$SpesialisCount);

        $DokterCount = Dokter::count();
        view()->share('DokterCount',$DokterCount);

        $PoliCount = Poliklinik::count();
        view()->share('PoliCount',$PoliCount);

        $PendaftaaranCount = Dokter::count();
        view()->share('PendaftaaranCount',$PendaftaaranCount);

        $DataObatCount = Obat::count();
        view()->share('DataObatCount',$DataObatCount);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
