import AppLogoIcon from './app-logo-icon';
import AppLogoWordmark from './app-logo-wordmark';

export default function AppLogo() {
    return (
        <>
            <div className="flex aspect-square size-8 items-center justify-center rounded-none">
                <AppLogoIcon className="text-primary size-8 fill-current dark:text-black" />
            </div>
            <div className="ml-1 grid flex-1 text-left text-sm">
                <AppLogoWordmark className="h-6 text-black" />
                {/* <span className="mb-0.5 truncate leading-none font-semibold">Laravel Starter Kit</span> */}
            </div>
        </>
    );
}
