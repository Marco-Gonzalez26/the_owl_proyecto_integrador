import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/admin-layout';
import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { AlertTriangle, Eye, EyeOff, Lock, Mail, MapPin, Phone, Save, Shield, User, X } from 'lucide-react';
import { useState } from 'react';

type User = {
    id: number;
    nombre_usuario: string;
    email: string;
    nombre_completo: string;
    correo: string;
    rol: number;
    direccion: string;
    telefono: string;
    identificacion: string;
    role?: {
        RolId: number;
        Nombre: string;
    };
};

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: '/the-owl/public/dashboard',
    },
    {
        title: 'Usuarios',
        href: '/the-owl/public/dashboard/users',
    },
    {
        title: 'Editar Usuario',
        href: '#',
    },
];

export default function EditUser() {
    const { roles, user } = usePage().props as { roles: any[]; user: User };
    const [showPassword, setShowPassword] = useState(false);
    const [showPasswordConfirm, setShowPasswordConfirm] = useState(false);
    const [changePassword, setChangePassword] = useState(false);

    const { data, setData, put, processing, errors } = useForm({
        nombre_usuario: user.nombre_usuario || '',
        email: user.email || '',
        correo: user.correo || '',
        password: '',
        password_confirmation: '',
        nombre_completo: user.nombre_completo || '',
        rol: user.rol?.toString() || '',
        direccion: user.direccion || '',
        telefono: user.telefono || '',
        identificacion: user.identificacion || '',
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        // Si no se quiere cambiar la contraseña, no la enviamos
        const submitData = { ...data };
        if (!changePassword) {
            delete submitData.password;
            delete submitData.password_confirmation;
        }

        put(route('api.users.update', user.id), {
            data: submitData,
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                router.push({ url: route('users.index') });
            },
        });
    };

    const selectedRole = roles.find((role) => role.RolId === parseInt(data.rol));

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Editar Usuario - ${user.nombre_completo}`} />
            <div className="min-h-screen bg-neutral-50">
                <div className="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="mb-8">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-3xl font-bold text-neutral-900">Editar Usuario</h1>
                                <p className="mt-2 text-sm text-neutral-600">
                                    Modificar información de: <span className="font-medium">{user.nombre_completo}</span>
                                </p>
                            </div>
                            <Link
                                href={route('users.index')}
                                className="inline-flex items-center rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium text-neutral-700 shadow-sm hover:bg-neutral-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
                            >
                                <X className="mr-2 h-4 w-4" />
                                Cancelar
                            </Link>
                        </div>
                    </div>

                    <form onSubmit={handleSubmit} className="space-y-6">
                        {/* Información Personal */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center">
                                    <User className="mr-2 h-5 w-5" />
                                    Información Personal
                                </CardTitle>
                                <CardDescription>Datos personales del usuario</CardDescription>
                            </CardHeader>
                            <CardContent className="space-y-6">
                                <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div className="space-y-2">
                                        <Label htmlFor="nombre_completo">Nombre Completo *</Label>
                                        <Input
                                            id="nombre_completo"
                                            type="text"
                                            placeholder="Ej: Juan Carlos Pérez"
                                            value={data.nombre_completo}
                                            onChange={(e) => setData('nombre_completo', e.target.value)}
                                            className={errors.nombre_completo ? 'border-red-500 focus:ring-red-500' : ''}
                                        />
                                        {errors.nombre_completo && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.nombre_completo}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="identificacion">Identificación *</Label>
                                        <Input
                                            id="identificacion"
                                            type="text"
                                            placeholder="Ej: 1234567890"
                                            value={data.identificacion}
                                            onChange={(e) => setData('identificacion', e.target.value)}
                                            className={errors.identificacion ? 'border-red-500 focus:ring-red-500' : ''}
                                        />
                                        {errors.identificacion && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.identificacion}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="telefono">Teléfono</Label>
                                        <div className="relative">
                                            <Phone className="absolute top-3 left-3 h-4 w-4 text-neutral-400" />
                                            <Input
                                                id="telefono"
                                                type="text"
                                                placeholder="Ej: 0987654321"
                                                value={data.telefono}
                                                onChange={(e) => setData('telefono', e.target.value)}
                                                className={`pl-10 ${errors.telefono ? 'border-red-500 focus:ring-red-500' : ''}`}
                                            />
                                        </div>
                                        {errors.telefono && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.telefono}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="rol">Rol *</Label>
                                        <Select value={data.rol} onValueChange={(value) => setData('rol', value)}>
                                            <SelectTrigger className={errors.rol ? 'border-red-500 focus:ring-red-500' : ''}>
                                                <SelectValue placeholder="Seleccionar rol" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {roles.map((role) => (
                                                    <SelectItem key={role.RolId} value={role.RolId.toString()}>
                                                        {role.Nombre}
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {errors.rol && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.rol}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2 md:col-span-2">
                                        <Label htmlFor="direccion">Dirección</Label>
                                        <div className="relative">
                                            <MapPin className="absolute top-3 left-3 h-4 w-4 text-neutral-400" />
                                            <Textarea
                                                id="direccion"
                                                placeholder="Dirección completa del usuario"
                                                rows={3}
                                                value={data.direccion}
                                                onChange={(e) => setData('direccion', e.target.value)}
                                                className={`pl-10 ${errors.direccion ? 'border-red-500 focus:ring-red-500' : ''}`}
                                            />
                                        </div>
                                        {errors.direccion && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.direccion}
                                            </p>
                                        )}
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Información de Acceso */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center">
                                    <Shield className="mr-2 h-5 w-5" />
                                    Información de Acceso
                                </CardTitle>
                                <CardDescription>Credenciales para el acceso al sistema</CardDescription>
                            </CardHeader>
                            <CardContent className="space-y-6">
                                <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div className="space-y-2">
                                        <Label htmlFor="nombre_usuario">Nombre de Usuario *</Label>
                                        <Input
                                            id="nombre_usuario"
                                            type="text"
                                            placeholder="Ej: juan.perez"
                                            value={data.nombre_usuario}
                                            onChange={(e) => setData('nombre_usuario', e.target.value)}
                                            className={errors.nombre_usuario ? 'border-red-500 focus:ring-red-500' : ''}
                                        />
                                        {errors.nombre_usuario && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.nombre_usuario}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="email">Email *</Label>
                                        <div className="relative">
                                            <Mail className="absolute top-3 left-3 h-4 w-4 text-neutral-400" />
                                            <Input
                                                id="email"
                                                type="email"
                                                placeholder="Ej: juan@empresa.com"
                                                value={data.email}
                                                onChange={(e) => setData('email', e.target.value)}
                                                className={`pl-10 ${errors.email ? 'border-red-500 focus:ring-red-500' : ''}`}
                                            />
                                        </div>
                                        {errors.email && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.email}
                                            </p>
                                        )}
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Cambio de Contraseña */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center">
                                    <Lock className="mr-2 h-5 w-5" />
                                    Cambiar Contraseña
                                </CardTitle>
                                <CardDescription>Actualizar la contraseña del usuario (opcional)</CardDescription>
                            </CardHeader>
                            <CardContent className="space-y-6">
                                <div className="flex items-center space-x-2">
                                    <input
                                        type="checkbox"
                                        id="change_password"
                                        checked={changePassword}
                                        onChange={(e) => {
                                            setChangePassword(e.target.checked);
                                            if (!e.target.checked) {
                                                setData('password', '');
                                                setData('password_confirmation', '');
                                            }
                                        }}
                                        className="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    />
                                    <Label htmlFor="change_password" className="text-sm font-medium">
                                        Cambiar contraseña
                                    </Label>
                                </div>

                                {changePassword && (
                                    <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        <div className="space-y-2">
                                            <Label htmlFor="password">Nueva Contraseña *</Label>
                                            <div className="relative">
                                                <Input
                                                    id="password"
                                                    type={showPassword ? 'text' : 'password'}
                                                    placeholder="Mínimo 8 caracteres"
                                                    value={data.password}
                                                    onChange={(e) => setData('password', e.target.value)}
                                                    className={`pr-10 ${errors.password ? 'border-red-500 focus:ring-red-500' : ''}`}
                                                />
                                                <button
                                                    type="button"
                                                    onClick={() => setShowPassword(!showPassword)}
                                                    className="absolute top-3 right-3 h-4 w-4 text-neutral-400 hover:text-neutral-600"
                                                >
                                                    {showPassword ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
                                                </button>
                                            </div>
                                            {errors.password && (
                                                <p className="flex items-center text-sm text-red-600">
                                                    <AlertTriangle className="mr-1 h-4 w-4" />
                                                    {errors.password}
                                                </p>
                                            )}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="password_confirmation">Confirmar Nueva Contraseña *</Label>
                                            <div className="relative">
                                                <Input
                                                    id="password_confirmation"
                                                    type={showPasswordConfirm ? 'text' : 'password'}
                                                    placeholder="Repite la nueva contraseña"
                                                    value={data.password_confirmation}
                                                    onChange={(e) => setData('password_confirmation', e.target.value)}
                                                    className={`pr-10 ${errors.password_confirmation ? 'border-red-500 focus:ring-red-500' : ''}`}
                                                />
                                                <button
                                                    type="button"
                                                    onClick={() => setShowPasswordConfirm(!showPasswordConfirm)}
                                                    className="absolute top-3 right-3 h-4 w-4 text-neutral-400 hover:text-neutral-600"
                                                >
                                                    {showPasswordConfirm ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
                                                </button>
                                            </div>
                                            {errors.password_confirmation && (
                                                <p className="flex items-center text-sm text-red-600">
                                                    <AlertTriangle className="mr-1 h-4 w-4" />
                                                    {errors.password_confirmation}
                                                </p>
                                            )}
                                        </div>

                                        {/* Indicador de fortaleza de contraseña */}
                                        {data.password && (
                                            <div className="rounded-lg border border-blue-200 bg-blue-50 p-4 md:col-span-2">
                                                <h4 className="mb-2 text-sm font-medium text-blue-900">Requisitos de Contraseña:</h4>
                                                <div className="space-y-1 text-sm">
                                                    <div
                                                        className={`flex items-center ${data.password.length >= 8 ? 'text-green-600' : 'text-red-600'}`}
                                                    >
                                                        <span className="mr-2">{data.password.length >= 8 ? '✓' : '✗'}</span>
                                                        Mínimo 8 caracteres
                                                    </div>
                                                    <div
                                                        className={`flex items-center ${/[A-Z]/.test(data.password) ? 'text-green-600' : 'text-red-600'}`}
                                                    >
                                                        <span className="mr-2">{/[A-Z]/.test(data.password) ? '✓' : '✗'}</span>
                                                        Al menos una mayúscula
                                                    </div>
                                                    <div
                                                        className={`flex items-center ${/[a-z]/.test(data.password) ? 'text-green-600' : 'text-red-600'}`}
                                                    >
                                                        <span className="mr-2">{/[a-z]/.test(data.password) ? '✓' : '✗'}</span>
                                                        Al menos una minúscula
                                                    </div>
                                                    <div
                                                        className={`flex items-center ${/\d/.test(data.password) ? 'text-green-600' : 'text-red-600'}`}
                                                    >
                                                        <span className="mr-2">{/\d/.test(data.password) ? '✓' : '✗'}</span>
                                                        Al menos un número
                                                    </div>
                                                </div>
                                            </div>
                                        )}
                                    </div>
                                )}
                            </CardContent>
                        </Card>

                        {/* Vista Previa del Usuario */}
                        {(data.nombre_completo || data.nombre_usuario || selectedRole) && (
                            <Card>
                                <CardHeader>
                                    <CardTitle>Vista Previa del Usuario</CardTitle>
                                    <CardDescription>Así se verá el usuario actualizado en el sistema</CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <div className="rounded-lg border bg-neutral-50 p-4">
                                        <div className="flex items-start space-x-4">
                                            <div className="flex-shrink-0">
                                                <div className="flex h-16 w-16 items-center justify-center rounded-full bg-blue-100">
                                                    <User className="h-6 w-6 text-blue-600" />
                                                </div>
                                            </div>
                                            <div className="min-w-0 flex-1">
                                                <h4 className="mb-1 text-lg font-medium text-neutral-900">
                                                    {data.nombre_completo || 'Nombre completo'}
                                                </h4>
                                                <p className="mb-2 text-sm text-neutral-500">@{data.nombre_usuario || 'usuario'}</p>
                                                {selectedRole && (
                                                    <span className="mb-2 inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                                        <Shield className="mr-1 h-3 w-3" />
                                                        {selectedRole.Nombre}
                                                    </span>
                                                )}
                                                <div className="mt-2 space-y-1">
                                                    {data.email && (
                                                        <p className="flex items-center text-sm text-neutral-600">
                                                            <Mail className="mr-2 h-3 w-3" />
                                                            {data.email}
                                                        </p>
                                                    )}
                                                    {data.telefono && (
                                                        <p className="flex items-center text-sm text-neutral-600">
                                                            <Phone className="mr-2 h-3 w-3" />
                                                            {data.telefono}
                                                        </p>
                                                    )}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        )}

                        {/* Botones de Acción */}
                        <Card>
                            <CardContent className="pt-6">
                                <div className="flex justify-end space-x-3">
                                    <Button variant="outline" type="button" asChild>
                                        <Link href={route('users.index')}>
                                            <X className="mr-2 h-4 w-4" />
                                            Cancelar
                                        </Link>
                                    </Button>
                                    <Button type="submit" disabled={processing}>
                                        {processing ? (
                                            <>
                                                <div className="mr-2 -ml-1 h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></div>
                                                Actualizando Usuario...
                                            </>
                                        ) : (
                                            <>
                                                <Save className="mr-2 h-4 w-4" />
                                                Actualizar Usuario
                                            </>
                                        )}
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>
                    </form>
                </div>
            </div>
        </AppLayout>
    );
}
