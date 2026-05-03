import { useMediaQuery } from "react-responsive";

const useScreenSize = (breakpoint = 1024) => {
  const isDesktopScreen = useMediaQuery({ minWidth: breakpoint });
  const isMobileScreen = useMediaQuery({ maxWidth: breakpoint - 1 });

  return { isDesktopScreen, isMobileScreen };
};

export default useScreenSize;
