import { Link } from "react-router";
import type { StoreType } from "../../types";
import { LuMapPin } from "react-icons/lu";
import { IoMdTime } from "react-icons/io";

interface StoreProps {
  store: StoreType;
}

const Store = ({ store }: StoreProps) => {
  const { name, address, city, email, phone, state, store_hours } = store || {};

  return (
    <div className="text-dark-light">
      <Link
        to={"/"}
        className="mb-2 text-primary lg:text-dark-light lg:hover:text-dark font-bold"
      >
        {name}, {state}, {city}
      </Link>

      <div className="mt-2 flex flex-col lg:flex-row gap-4 justify-between text-sm">
        <div className="space-y-4">
          <div className="ps-1 flex items-start gap-2">
            <LuMapPin className="mt-1" />
            <div className="text-dark lg:text-dark-light">
              <p>{address}</p>
              <p>Email: {email}</p>
              <p>Tel: {phone}</p>
            </div>
          </div>

          <div className="ps-1 flex items-start gap-2">
            <IoMdTime className="mt-px" />
            <div className="text-dark-deep lg:text-dark-light">
              <p className="font-semibold">Store Hours</p>
              <p>{store_hours}</p>
            </div>
          </div>
        </div>

        <div className="w-full lg:w-56 px-8 lg:px-0 flex flex-col gap-3">
          <a
            href="/"
            target="_blank"
            title="/"
            className="w-full uppercase text-primary-dark font-semibold border p-2 text-center hover:bg-gray-300 hover:bg-opacity-30"
          >
            Get Directions
          </a>

          <Link
            to={"/"}
            className="w-full uppercase text-primary-dark font-semibold border p-2 text-center hover:bg-gray-300 hover:bg-opacity-30"
          >
            Store Page
          </Link>
        </div>
      </div>
    </div>
  );
};

export default Store;
