import { useSearchParams } from "react-router";
import {
  MdOutlineRadioButtonUnchecked,
  MdRadioButtonChecked,
} from "react-icons/md";
import type { DiscountFilterType } from "../../../../types/productsFilter";
import type { Id } from "../../../../types";

interface DiscountFilterProps {
  discountFilter: DiscountFilterType;
}

const DiscountFilter = ({ discountFilter }: DiscountFilterProps) => {
  const { options, active_discount_id } = discountFilter;
  const [, setSearchParams] = useSearchParams();

  const toggleFilter = (id: Id) => {
    setSearchParams((params) => {
      if (params.get("discount_id") === id.toString()) {
        params.delete("discount_id");
      } else {
        params.set("discount_id", id.toString());
      }

      return params;
    });
  };

  return (
    <ul className="space-y-3">
      {options.map((opt, idx) => {
        const { id, label, count } = opt;
        const isApplied = active_discount_id === id;

        return (
          <li key={idx}>
            <button
              onClick={() => toggleFilter(id)}
              className="w-full flex justify-between items-center gap-3"
            >
              <span className="flex-none flex items-center gap-2">
                {isApplied ? (
                  <MdRadioButtonChecked size={24} className="text-primary" />
                ) : (
                  <MdOutlineRadioButtonUnchecked
                    size={24}
                    className="text-primary-light"
                  />
                )}

                <span className="text-sm">{label}</span>
              </span>

              <span className="text-xs text-dark-light">({count})</span>
            </button>
          </li>
        );
      })}
    </ul>
  );
};

export default DiscountFilter;
