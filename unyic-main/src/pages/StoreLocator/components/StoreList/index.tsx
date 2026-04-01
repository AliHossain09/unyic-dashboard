import type { StoreType } from "../../types";
import Store from "./Store";

interface StoreListProps {
  stores: StoreType[];
}

const StoreList = ({ stores }: StoreListProps) => {
  if (!stores || stores.length === 0) {
    return <p className="text-dark-light">No store found.</p>;
  }

  return (
    <div className="space-y-6">
      {stores.map((store, idx) => (
        <Store key={idx} store={store} />
      ))}
    </div>
  );
};

export default StoreList;
