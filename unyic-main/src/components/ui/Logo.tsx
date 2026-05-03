import { Link } from "react-router";
import logo from "../../assets/images/logo.png";

const Logo = () => {
  return (
    <Link to="/">
      <img src={logo} alt="unyic" className="h-6 lg:h-7 object-contain" />
    </Link>
  );
};

export default Logo;
