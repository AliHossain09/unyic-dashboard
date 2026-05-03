import { BsHandbag } from "react-icons/bs";
import { Link } from "react-router";
import MiniCart from "./MiniCart";
import useCartContext from "../../../../../contexts/cart/useCartContext";
import IconBadge from "../IconBadge";

const CartLink = () => {
  const { cart } = useCartContext();

  return (
    <div className="relative group">
      <Link to={"cart"} className="relative">
        <IconBadge Icon={BsHandbag} count={cart.length} />
      </Link>

      <MiniCart />
    </div>
  );
};

export default CartLink;
