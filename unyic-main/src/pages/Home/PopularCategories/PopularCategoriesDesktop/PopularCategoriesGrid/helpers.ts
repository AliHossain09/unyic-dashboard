import clsx from "clsx";

export const aspectRatios = [
  "aspect-[7/6]", // postion 1
  "aspect-[9/8]", // postion 2
  "aspect-[6/7]", // postion 3
  "aspect-[5/3]", // postion 4
  "aspect-[6/7]", // postion 5
  "aspect-[5/3]", // postion 6
  "aspect-[7/6]", // postion 7
  "aspect-[9/8]", // postion 8
];

// build className for the image wrapper
export function getImageWrapperClasses(colIndex: number, itemIndex: number) {
  const index = colIndex * 2 + itemIndex;
  const isFirst = index === 0;
  const isLast = index === 7;

  return clsx(
    "relative w-full overflow-hidden bg-gray-200",
    aspectRatios[index],
    {
      "rounded-ss-[50px]": isFirst,
      "rounded-ee-[50px]": isLast,
    }
  );
}
