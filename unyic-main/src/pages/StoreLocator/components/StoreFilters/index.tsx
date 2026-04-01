import DropdownSelector from "../../../../components/ui/DropdownSelector";
import { states } from "../../data";

interface StoreFiltersProps {
  selectedState: string;
  selectedCity: string | null;
  availableCities: string[];
  onStateChange: (state: string) => void;
  onCityChange: (city: string | null) => void;
}

const StoreFilters = ({
  selectedState,
  selectedCity,
  availableCities,
  onStateChange,
  onCityChange,
}: StoreFiltersProps) => {
  return (
    <div className="flex flex-col gap-4 lg:flex-row lg:gap-0 lg:items-center">
      <div className="w-full lg:w-52 space-y-2">
        <p className="uppercase mb-2">STATE</p>

        <DropdownSelector
          selected={selectedState}
          list={["All", ...states.map((state) => state.name)]}
          onSelect={onStateChange}
          defaultText="All"
        />
      </div>

      <div className="w-full lg:w-52 space-y-2">
        <p className="block uppercase mb-2">CITY</p>

        <DropdownSelector
          selected={selectedCity}
          list={availableCities}
          onSelect={onCityChange}
          defaultText={
            selectedState && selectedState !== "All"
              ? "-- Select City --"
              : "All"
          }
          disabled={!selectedState || selectedState === "All"}
        />
      </div>
    </div>
  );
};

export default StoreFilters;
