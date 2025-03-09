import AppLogoIcon from '@/components/app-logo-icon';
import AppLogoWordmark from '@/components/app-logo-wordmark';
import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth, quote } = usePage<SharedData>().props;

    return (
        <>
            <Head title="Welcome">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>

            <div className="flex min-h-screen flex-col items-center bg-[#FDFDFC] text-[#1b1b18] lg:justify-center dark:bg-[#0a0a0a]">
                <header className="w-full border-b py-4 text-sm not-has-[nav]:hidden">
                    <nav className="mx-auto flex w-full max-w-screen-xl justify-between gap-4 px-4 md:px-0 lg:max-w-4xl">
                        <div className="flex items-center gap-2">
                            <div className="flex aspect-square size-8 items-center justify-center rounded-none">
                                <AppLogoIcon className="text-primary size-8 fill-current dark:text-black" />
                            </div>
                            <div className="ml-1 grid flex-1 text-left text-sm">
                                <AppLogoWordmark className="h-6 text-black" />
                            </div>
                        </div>

                        <div className="flex items-center justify-end gap-2 md:gap-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="neolift-effect inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18]"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="neolift-effect bg-primary inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal"
                                    >
                                        Register
                                    </Link>
                                </>
                            )}
                        </div>
                    </nav>
                </header>
                <div className="bg-primary flex w-full flex-grow items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                    <main className="neolift-effect flex min-h-[400px] w-full max-w-[335px] flex-col items-center rounded-sm border bg-amber-500 px-4 py-4 md:px-8 lg:max-w-4xl dark:bg-[#0a0a0a]">
                        <p className="mt-8 text-center text-3xl md:text-4xl">Bills Payment Solution that was made specifically for you. Watch out!</p>

                        {quote && (
                            <div className="relative z-20 mt-auto">
                                <blockquote className="space-y-2 text-black">
                                    <p className="text-lg">&ldquo;{quote.message}&rdquo;</p>
                                    <footer className="text-center text-sm text-neutral-800">-{quote.author}</footer>
                                </blockquote>
                            </div>
                        )}
                    </main>
                </div>
            </div>
        </>
    );
}
