import clsx from "clsx";

interface DividerProps {
  className?: string;
}

const Divider = ({ className }: DividerProps) => {
  return (
    <div className={clsx("lg:hidden h-2 bg-dark-light/10 -mx-3", className)} />
  );
};

export default Divider;
