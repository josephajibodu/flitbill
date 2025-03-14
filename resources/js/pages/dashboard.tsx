import AppLayout from "@/layouts/app-layout"
import type {BreadcrumbItem} from "@/types"
import {Head} from "@inertiajs/react"
import {Button} from "@/components/ui/button"
import {Database, MoreHorizontal, Phone, Tv, WalletMinimal, Zap} from "lucide-react"
import {Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow} from "@/components/ui/table";
import {
    Pagination,
    PaginationContent, PaginationEllipsis,
    PaginationItem,
    PaginationLink, PaginationNext,
    PaginationPrevious
} from "@/components/ui/pagination";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Dashboard",
        href: "/dashboard",
    },
]

export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard"/>
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <h1 className="text-xl">
                    Welcome back, <b>Esther!</b>
                </h1>
                <div className="grid grid-cols-1 sm:grid-cols-2 h-full flex-1 flex-col gap-6 rounded-xl">
                    <div className="flex flex-col gap-8">
                        <div className="bg-primary neo-card-border px-4 sm:px-6 py-8 h-[220px] sm:h-[300px] flex flex-col justify-between">
                            <div className="sm:mt-16">
                                <div className="flex items-center gap-4">
                                  <span className="neo-icon size-14 flex items-center justify-center">
                                    <WalletMinimal className="size-8 text-app-black"/>
                                  </span>
                                    <div>
                                        <span className="text-app-black font-medium">Wallet Balance</span>
                                        <h2 className="text-3xl font-bold text-app-black">₦200.00</h2>
                                    </div>
                                </div>
                            </div>

                            <div className="flex gap-4 mt-8">
                                <Button variant="secondary" className="text-app-black neo-button w-full hover:bg-unset">Add
                                    Funds</Button>
                                <Button className="bg-neo-pink text-app-black hover:bg-unset neo-button w-full">Withdraw
                                    Funds</Button>
                            </div>
                        </div>

                        {/* Quick Links */}
                        <div className="bg-background neo-card-borders p-5s">
                            <h3 className="font-bold mb-4">Quick Links</h3>
                            <div className="grid grid-cols-3 sm:grid-cols-5 gap-4">
                                <a
                                    href="#"
                                    className="flex flex-col items-center justify-center gap-2 p-3 bg-primary/20 rounded-md neolift-effect"
                                >
                                    <Database className="size-6 text-app-black" />
                                    <span className="text-xs font-medium text-app-black">Data</span>
                                </a>
                                <a
                                    href="#"
                                    className="flex flex-col items-center justify-center gap-2 p-3 bg-primary/20 rounded-md neolift-effect"
                                >
                                    <Phone className="size-6 text-app-black" />
                                    <span className="text-xs font-medium text-app-black">Airtime</span>
                                </a>
                                <a
                                    href="#"
                                    className="flex flex-col items-center justify-center gap-2 p-3 bg-primary/20 rounded-md neolift-effect"
                                >
                                    <Zap className="size-6 text-app-black" />
                                    <span className="text-xs font-medium text-app-black">Electricity</span>
                                </a>
                                <a
                                    href="#"
                                    className="flex flex-col items-center justify-center gap-2 p-3 bg-primary/20 rounded-md neolift-effect"
                                >
                                    <Tv className="size-6 text-app-black" />
                                    <span className="text-xs font-medium text-app-black">Cable</span>
                                </a>
                                <a
                                    href="#"
                                    className="flex flex-col items-center justify-center gap-2 p-3 bg-primary/20 rounded-md neolift-effect"
                                >
                                    <MoreHorizontal className="size-6 text-app-black" />
                                    <span className="text-xs font-medium text-app-black">More</span>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div className="min-h-[300px]">
                        <h2 className="text-2xl font-bold">Recent Activity</h2>
                        <div className="mt-4">
                            {/* Placeholder for activity content */}
                            <div className="bg-background neo-card p-4 mb-3 hidden">
                                <p className="font-medium">No recent transactions</p>
                            </div>

                            <div className="neo-card-border">
                                <Table>
                                    <TableCaption className="sr-only">A list of your recent transactions.</TableCaption>
                                    <TableHeader className="py-4">
                                        <TableRow>
                                            <TableHead>Type</TableHead>
                                            <TableHead>Amount</TableHead>
                                            <TableHead>Date</TableHead>
                                            <TableHead className="text-right">Status</TableHead>
                                        </TableRow>
                                    </TableHeader>

                                    <TableBody>
                                        {Array.from({ length: 10}).map((_, index) => (
                                            <TableRow key={index}>
                                                <TableCell className="font-medium py-4">Giftcard</TableCell>
                                                <TableCell>20,000</TableCell>
                                                <TableCell>Today, 10:12pm</TableCell>
                                                <TableCell className="text-right">
                                                    Success
                                                </TableCell>
                                            </TableRow>
                                        ))}
                                    </TableBody>
                                </Table>
                            </div>

                            <div className="mt-4 hidden">
                                <Pagination>
                                    <PaginationContent>
                                        <PaginationItem>
                                            <PaginationPrevious href="#" />
                                        </PaginationItem>
                                        <PaginationItem>
                                            <PaginationLink href="#">1</PaginationLink>
                                        </PaginationItem>
                                        <PaginationItem>
                                            <PaginationEllipsis />
                                        </PaginationItem>
                                        <PaginationItem>
                                            <PaginationNext href="#" />
                                        </PaginationItem>
                                    </PaginationContent>
                                </Pagination>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    )
}