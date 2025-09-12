import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/admin-layout';
import { Head, Link, useForm } from '@inertiajs/react';
import { Package, Pen, Plus, Search, Trash } from 'lucide-react';
import { useMemo, useState } from 'react';
import { toast } from 'sonner';

type Brand = {
    MarcaId: number;
    Nombre: string;
    Estado: boolean;
};

const breadcrumbs: any[] = [
    {
        title: 'Dashboard',
        href: '/the-owl/public/dashboard',
    },
    {
        title: 'Tamaños',
        href: '/the-owl/public/dashboard/brands',
    },
];
export default function Index({ brands }: { brands: Brand[] }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [currentPage, setCurrentPage] = useState(1);
    const { processing, delete: destroy } = useForm();
    const itemsPerPage = 15;

    const filteredBrands = useMemo(() => {
        return brands.filter((brand) => {
            const matchesSearch =
                brand.Nombre.toLowerCase().includes(searchTerm.toLowerCase()) || brand.Nombre.toLowerCase().includes(searchTerm.toLowerCase());

            return matchesSearch;
        });
    }, [brands, searchTerm]);

    const totalPages = Math.ceil(filteredBrands.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const paginatedBrands = filteredBrands.slice(startIndex, startIndex + itemsPerPage);

    const deleteBrand = (id: number) => {
        destroy(`/the-owl/public/dashboard/api/brands/${id}/delete`, {
            onSuccess: () => {
                toast.success('Marca eliminada correctamente');
                setCurrentPage(1);
            },
            onError: () => {
                toast.error('Error al eliminar marca');
            },
        });
    };

    return ()
}

