import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AuthLayout from '@/layouts/auth-layout';

type RegisterForm = {
    nombre_completo: string;
    correo: string;
    nombre_usuario: string;
    direccion: string;
    telefono: string;
    identificacion: string;
    contrasena: string;
    contrasena_confirmacion: string;
};

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm<Required<RegisterForm>>({
        nombre_completo: '',
        nombre_usuario: '',
        correo: '',
        direccion: '',
        telefono: '',
        identificacion: '',
        contrasena: '',
        contrasena_confirmacion: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('register'), {
            onFinish: () => reset('contrasena', 'contrasena_confirmacion'),
        });
    };

    return (
        <AuthLayout
            title="Crea una cuenta para disfrutar de la experiencia completa"
            description="Al crear una cuenta, aceptas que tus datos se almacenen en nuestro servidor y se utilizan para proporcionarte el mejor servicio posible."
        >
            <Head title="Crear cuenta | The Owl" />
            <form className="flex w-full flex-col gap-6" onSubmit={submit}>
                <div className="grid items-center gap-6 md:grid-cols-2">
                    <div className="grid gap-2">
                        <Label htmlFor="name">Nombre Completo</Label>
                        <Input
                            id="name"
                            type="text"
                            required
                            autoFocus
                            tabIndex={1}
                            autoComplete="name"
                            value={data.nombre_completo}
                            onChange={(e) => setData('nombre_completo', e.target.value)}
                            disabled={processing}
                            placeholder="Nombre completo"
                        />
                        <InputError message={errors.nombre_completo} className="mt-2" />
                    </div>
                    <div className="grid gap-2">
                        <Label htmlFor="username">Nombre de usuario</Label>
                        <Input
                            id="username"
                            type="text"
                            required
                            autoFocus
                            tabIndex={1}
                            autoComplete="username"
                            value={data.nombre_usuario}
                            onChange={(e) => setData('nombre_usuario', e.target.value)}
                            disabled={processing}
                            placeholder="Nombre completo"
                        />
                        <InputError message={errors.nombre_usuario} className="mt-2" />
                    </div>
                    <div className="grid gap-2">
                        <Label htmlFor="email">Correo Electrónico</Label>
                        <Input
                            id="email"
                            type="email"
                            required
                            tabIndex={2}
                            autoComplete="email"
                            value={data.correo}
                            onChange={(e) => setData('correo', e.target.value)}
                            disabled={processing}
                            placeholder="correo@ejemplo.com"
                        />
                        <InputError message={errors.correo} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="password">Contraseña</Label>
                        <Input
                            id="password"
                            type="password"
                            required
                            tabIndex={3}
                            autoComplete="new-password"
                            value={data.contrasena}
                            onChange={(e) => setData('contrasena', e.target.value)}
                            disabled={processing}
                            placeholder="Contreña segura"
                        />
                        <InputError message={errors.contrasena} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="password_confirmation">Confirmar constraseña</Label>
                        <Input
                            id="password_confirmation"
                            type="password"
                            required
                            tabIndex={4}
                            autoComplete="new-password"
                            value={data.contrasena_confirmacion}
                            onChange={(e) => setData('contrasena_confirmacion', e.target.value)}
                            disabled={processing}
                            placeholder="Confirmar constraseña segura"
                        />
                        <InputError message={errors.contrasena_confirmacion} />
                    </div>
                    <div className="grid gap-2">
                        <Label htmlFor="phoneNumber">Número de teléfono</Label>
                        <Input
                            id="phoneNumber"
                            type="tel"
                            required
                            tabIndex={4}
                            autoComplete="phonenumber"
                            value={data.telefono}
                            onChange={(e) => setData('telefono', e.target.value)}
                            disabled={processing}
                            placeholder="Número de teléfono"
                        />
                        <InputError message={errors.telefono} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="address">Dirección</Label>
                        <Textarea
                            name="address"
                            className="resize-none"
                            id="address"
                            rows={3}
                            required
                            tabIndex={4}
                            autoComplete="address-line1"
                            value={data.direccion}
                            onChange={(e) => setData('direccion', e.target.value)}
                            disabled={processing}
                            placeholder="Dirección"
                        />
                        <small className="text-sm text-muted-foreground">Se solicita para realizar el envío de la compra</small>
                        <InputError message={errors.direccion} />
                    </div>
                    <div className="grid gap-2">
                        <Label htmlFor="identification">Cédula de identidad</Label>
                        <Input
                            name="identification"
                            id="identification"
                            required
                            min={10}
                            tabIndex={4}
                            autoComplete="identification"
                            value={data.identificacion}
                            onChange={(e) => setData('identificacion', e.target.value)}
                            disabled={processing}
                            placeholder="2300000000"
                        />
                        <small className="text-sm text-muted-foreground">Se solicita para realizar la factura de la compra</small>
                        <InputError message={errors.identificacion} />
                    </div>
                </div>

                <Button type="submit" className="mt-2 w-full" tabIndex={5} disabled={processing}>
                    {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                    Crear cuenta
                </Button>

                <div className="text-center text-sm text-muted-foreground">
                    ¿Ya tienes una cuenta?{' '}
                    <TextLink href={route('login')} tabIndex={6}>
                        Inicia sesión
                    </TextLink>
                </div>
            </form>
        </AuthLayout>
    );
}
