import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/app-layout';
import { cn } from '@/lib/utils';
import type { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import { CreditCard, Receipt } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Buy Airtime',
        href: route('airtime.create'),
    },
];

const networks = [
    { name: 'MTN', logo: '/images/providers/mtn.svg', color: '#ffce27' },
    { name: 'Airtel', logo: '/images/providers/airtel.svg', color: '#ff1f1a' },
    { name: 'Glo', logo: '/images/providers/glo.svg', color: '#448141' },
    { name: '9mobile', logo: '/images/providers/9mobile.svg', color: '#1b765d' },
];

export default function BuyAirtime() {
    const { data, setData } = useForm({
        network: '',
        phone_number: '',
        amount: '',
    });

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid h-full flex-1 grid-cols-1 flex-col gap-6 rounded-xl sm:grid-cols-2">
                    {/* Form */}
                    <Card className="neo-card-border">
                        <CardContent>
                            <h2 className="mb-4 text-base font-medium">Select Network Provider</h2>
                            <div className="flex flex-wrap gap-4">
                                {networks.map((network) => (
                                    <label
                                        className={cn(
                                            'neo-card-border neolift-effect-highlight group has-checked:neolift-effect flex h-[100px] cursor-pointer flex-col items-center justify-center gap-2 rounded-lg bg-white p-4 has-checked:text-white sm:w-[100px]',
                                            {
                                                'neo-active': data.network === network.name,
                                            },
                                        )}
                                        style={
                                            {
                                                '--highlight': network.color,
                                            } as React.CSSProperties
                                        }
                                    >
                                        <input
                                            type="radio"
                                            name="provider"
                                            className="hidden"
                                            checked={data.network === network.name}
                                            onChange={() => setData('network', network.name)}
                                        />
                                        <div className="flex flex-col items-center">
                                            <img
                                                src={network.logo}
                                                alt={network.name}
                                                className="h-14 min-w-20 grayscale transition-all duration-200 group-hover:grayscale-0 group-has-checked:grayscale-0"
                                            />
                                            <span className="text-app-black sr-only">{network.name}</span>
                                        </div>
                                    </label>
                                ))}
                            </div>

                            <div className="mt-6 grid w-full items-center gap-1.5">
                                <Label htmlFor="phone_number" className="text-base">
                                    Phone Number
                                </Label>
                                <Input
                                    type="tel"
                                    id="phone_number"
                                    placeholder="08012345678"
                                    value={data.phone_number}
                                    onChange={(e) => setData('phone_number', e.target.value)}
                                />
                            </div>

                            <div className="mt-6 grid w-full items-center gap-1.5">
                                <div className="flex items-center justify-between">
                                    <Label htmlFor="amount" className="text-base">
                                        Amount
                                    </Label>
                                    <span className="text-sm">
                                        Min: <span className="font-semibold">₦100</span> | Max: <span className="font-semibold">₦100,000</span>
                                    </span>
                                </div>
                                <Input
                                    type="text"
                                    id="amount"
                                    placeholder="₦0.00"
                                    value={data.amount}
                                    onChange={(e) => setData('amount', e.target.value)}
                                />

                                <div className="flex gap-4 overflow-x-auto py-2">
                                    {[500, 1000, 2000, 5000, 10_000].map((amt, index) => (
                                        <Button
                                            key={index}
                                            variant="secondary"
                                            className="text-app-black neolift-effect hover:bg-primary h-10 w-[80px]"
                                            onClick={() => setData('amount', amt.toString())}
                                        >
                                            +{amt}
                                        </Button>
                                    ))}
                                </div>
                            </div>

                            <div className="mt-6 flex items-center space-x-2">
                                <Checkbox id="terms" />
                                <label
                                    htmlFor="terms"
                                    className="text-base leading-none font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                >
                                    Add to beneficiary
                                </label>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="shadow-md">
                        <CardHeader>
                            <CardTitle>Order Summary</CardTitle>
                            <CardDescription>Review your purchase details</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                <div className="bg-muted/50 flex items-center gap-4 rounded-lg p-4">
                                    <div className="flex items-center gap-3">
                                        <div className="flex w-20 items-center justify-center rounded-full">
                                            <img
                                                src={
                                                    networks.find((network) => network.name === data.network)?.logo ||
                                                    '/placeholder.svg?height=30&width=30'
                                                }
                                                alt={data.network || 'Network'}
                                                className="h-14 min-w-10"
                                            />
                                        </div>
                                        <div>
                                            <p className="font-medium">{data.network ?? 'Select Network'}</p>
                                            <p className="text-muted-foreground text-sm">{data.phone_number ?? 'No number selected'}</p>
                                        </div>
                                    </div>
                                </div>

                                <div className="space-y-3">
                                    <div className="flex justify-between">
                                        <span className="text-muted-foreground">Airtime Amount</span>
                                        <span className="font-medium">₦{data.amount}</span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span className="text-muted-foreground">Service Fee</span>
                                        <span className="font-medium">₦0</span>
                                    </div>
                                    <Separator />
                                    <div className="flex justify-between">
                                        <span className="font-medium">Total</span>
                                        <span className="font-bold">₦{data.amount}</span>
                                    </div>
                                </div>

                                <div className="space-y-3 pt-4">
                                    <div className="flex items-center gap-2 text-sm">
                                        <CreditCard className="text-muted-foreground h-4 w-4" />
                                        <span>Secure payment processing</span>
                                    </div>
                                    <div className="flex items-center gap-2 text-sm">
                                        <Receipt className="text-muted-foreground h-4 w-4" />
                                        <span>Instant airtime delivery</span>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}
