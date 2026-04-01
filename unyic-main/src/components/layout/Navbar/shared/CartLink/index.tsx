import { BsHandbag } from "react-icons/bs";
import { Link } from "react-router";
import MiniCart from "./MiniCart";
import useModalById from "../../../../../hooks/useModalById";
import useUser from "../../../../../hooks/useUser";
import useCartContext from "../../../../../contexts/cart/useCartContext";
import IconBadge from "../IconBadge";

const CartLink = () => {
  const { openModalWithData } = useModalById("authModal");
  const { user } = useUser();
  const { cart } = useCartContext();

  if (!user) {
    return (
      <button
        onClick={() => openModalWithData({ activeTab: "login" })}
        className="cursor-pointer"
        aria-label="Cart button to open login modal"
      >
        <IconBadge Icon={BsHandbag} />
      </button>
    );
  }

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
