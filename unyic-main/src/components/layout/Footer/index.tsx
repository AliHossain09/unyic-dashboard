import useScreenSize from "../../../hooks/useScreenSize";
import FooterDesktop from "./FooterDesktop";
import FooterMobile from "./FooterMobile";

const Footer = () => {
  const { isDesktopScreen } = useScreenSize();

  return isDesktopScreen ? <FooterDesktop /> : <FooterMobile />;
};

export default Footer;
